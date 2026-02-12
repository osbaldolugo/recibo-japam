<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Category;
use App\Models\Agent;
use App\Models\Setting;
use Cache;
use DB;
use Mail;
use Storage;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Swift_TransportException;

class AdministratorsController extends Controller
{
    public function index()
    {
        $administrators = Agent::admins();

        return view('kordy.admin.administrator.index', compact('administrators'));
    }

    /**
     * Lista de usuarios generados que tienen acceso al sistema
     *
     * @param UserDataTable $userDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function usersList(UserDataTable $userDataTable)
    {
        //Lista de categorías en las que puede ser agregado un usuario
        $all_categories = Category::all();
        return $userDataTable->render('admin.index', compact('all_categories'));
    }

    /**
     * Agrega o quita los permisos de Administrador
     *
     * @param $id
     * @param $is_admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAdministrator($id, $is_admin)
    {
        try {
            //Actualizamos los permisos de un usuario para determinar si sera administrador o no
            $user = Agent::where('id', $id)->update(['ticketit_admin' => $is_admin]);
            return response()->json(['content' => 'La información del usuario ha sido actualizada', 'title' => 'Permisos de administrador'], 200);
        } catch (QueryException $e) {
            DB::rollBack();
            \Log::error('Code: ' . $e->getCode() . ' Error: ' . $e->getMessage());
            return response()->json(['message' => 'Code: ' . $e->getCode() . '<br/>' . $e->getMessage()], 422);
        }
    }

    /**
     * Agrega o quita los permisos de Agente
     *
     * @param $id
     * @param $is_agent
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAgent($id, $is_agent)
    {
        try {
            //Actualizamos los permisos de un usuario para determinar si sera agente o no
            $user = Agent::where('id', $id)->update(['ticketit_agent' => $is_agent]);
            return response()->json(['content' => 'La información del usuario ha sido actualizada', 'title' => 'Permisos de agente'], 200);
        } catch (QueryException $e) {
            DB::rollBack();
            \Log::error('Code: ' . $e->getCode() . ' Error: ' . $e->getMessage());
            return response()->json(['message' => 'Code: ' . $e->getCode() . '<br/>' . $e->getMessage()], 422);
        }
    }

    public function create()
    {
        $users = Agent::paginate(Setting::grab('paginate_items'));

        return view('kordy.admin.administrator.create', compact('users'));
    }

    public function store(Request $request)
    {
        $administrators_list = $this->addAdministrators($request->input('administrators'));
        $administrators_names = implode(',', $administrators_list);

        Session::flash('status', trans('lang.administrators-are-added-to-administrators', ['names' => $administrators_names]));

        return redirect()->action('AdministratorsController@index');
    }

    /**
     * Crear un usuario
     *
     * @param CreateUserRequest $CreateUserRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function storeUser(CreateUserRequest $CreateUserRequest)
    {
        try {
            //dd(route('login'));
            $userRequest = $CreateUserRequest->input('user');
            $categoriesRequest = $CreateUserRequest->input('category');
            //En caso de que se envie una imagen la subimos al servidor
            if ($CreateUserRequest->hasFile('image')) {
                $image = $CreateUserRequest->file('image');
                $imageName = date("YmdHis", time()) . '.' . $image->getClientOriginalExtension();
                $userRequest['url_image'] = $imageName;
                $imagePath = 'public/user/' . $imageName;
                Storage::put($imagePath, file_get_contents($image));
            }
            //Guardamos la contraseña antes de encriptarla para mandarla al correo
            $password = $userRequest['password'];
            //Encriptamos la contraseña
            $userRequest['password'] = bcrypt($userRequest['password']);
            //Determinoamos si el usuario tendra permisos de agente o de administrador
            $userRequest['ticketit_agent'] = isset($userRequest['ticketit_agent']) ? 1 : 0;
            $userRequest['ticketit_admin'] = isset($userRequest['ticketit_admin']) ? 1 : 0;
            DB::beginTransaction();
            //Creamos al usuario
            $user = Agent::create($userRequest);
            //$category = Category::whereIn('id', $categoriesRequest)->get();
            //Relacionamos el usuario con la categoria
            //La categoria debe estar limitada a una
            $user->categories()->attach($categoriesRequest);
            try {
                //Enviamos el correo para notificar al usuario de sus credenciales y la ruta de acceso al Portal
                Mail::send('emails.registro', ['email' => $userRequest['email'], 'password' => $password, 'route' => route('login'), 'name' => $CreateUserRequest['name']], function ($message) use ($userRequest) {
                    $message->to($userRequest['email'])->subject('Usuario JAPAM');
                });
            } catch (Swift_TransportException $ex) {
                //En caso de que el correo no pueda ser enviado revertimos todos los procesos de la BD ya que no fue posible notificar al usuario
                DB::rollBack();
                return response()->json(['errors' => [$ex->getMessage()]], 422);
            }
            DB::commit();
            //Devolvemos una respuesta satifactoria
            return response()->json(['title' => $userRequest['name'], 'content' => 'Fue registrado en el sistema y notificado por correo'], 200);
        } catch (QueryException $e) {
            //Revertimos los procesos de la BD en caso de cualquier falla al momento de inserción en la BD
            DB::rollBack();
            \Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            //return response()->json(['errors' => ['Error al generar el usuario']],422);
            return response()->json(['errors' => ['Error' => $e->getMessage()]], 422);
        }
    }

    /**
     * Devuelve la información del usuario que se desea actualizar
     *
     * @param $id_user
     * @return \Illuminate\Http\JsonResponse
     */
    public function editUser($id_user)
    {
        try {
            $user = Agent::where('id', $id_user)->with('categories')->get()->toArray();
            return response()->json($user[0], 200);
        } catch (QueryException $e) {
            DB::rollBack();
            \Log::error('Error Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['Información inaccesible' => 'No fue posible consultar la información del usuario']], 422);
        }
    }

    /**
     * Actualiza la información de un usuario
     *
     * @param $id_user
     * @param UpdateUserRequest $updateUserRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateUser($id_user, UpdateUserRequest $updateUserRequest)
    {
        try {
            $userRequest = $updateUserRequest->input('user');
            $categoriesRequest = $updateUserRequest->input('category');
            //Identificamos el usuario que deseamos actualizar
            $user = Agent::find($id_user);
            if ($user) {
                DB::beginTransaction();
                //En caso de que se envie una imagen la actualizamos en el servidor
                if ($updateUserRequest->hasFile('image')) {
                    $image = $updateUserRequest->file('image');
                    $imageName = date("YmdHis", time()) . '.' . $image->getClientOriginalExtension();
                    //                $userRequest['url_image'] = $imageName;
                    $imagePath = 'public/user/' . $imageName;
                    Storage::put($imagePath, file_get_contents($image));
                    if (!empty($user->url_image))
                        Storage::delete('public/user/' . $user->url_image);
                    $user->url_image = $imageName;
                }
                //Actualizamos unicamente la información que puede cambiar [Nombre y permisos]
                $password = $userRequest['password'];
                $user->name = $userRequest['name'];
                if (!empty($password))
                    $user->password = bcrypt($userRequest['password']);
                $user->ticketit_agent = isset($userRequest['ticketit_agent']) ? 1 : 0;
                $user->ticketit_admin = isset($userRequest['ticketit_admin']) ? 1 : 0;
                $user->save();
                //$category = Category::whereIn('id', $categoriesRequest)->get();
                //Agregamos la relación con la categoria
                $user->categories()->sync($categoriesRequest);
                /*$category_detach = Category::where('id', '!=', $categoriesRequest)->get();
                //Quitamos la relación en caso de que se haya cambiado la categoria
                $user->categories()->detach($category_detach);*/
                if (!empty($password))
                    try {
                        //Enviamos el correo para notificar al usuario de sus credenciales y la ruta de acceso al Portal
                        Mail::send('emails.registro', ['email' => $user->email, 'password' => $password, 'route' => route('login'), 'name' => $userRequest['name']], function ($message) use ($user) {
                            $message->to($user->email)->subject('Usuario JAPAM');
                        });
                    } catch (Swift_TransportException $ex) {
                        //En caso de que el correo no pueda ser enviado revertimos todos los procesos de la BD ya que no fue posible notificar al usuario
                        DB::rollBack();
                        return response()->json(['errors' => [$ex->getMessage()]], 422);
                    }
                DB::commit();
                return response()->json(['title' => $userRequest['name'], 'content' => 'Su información a sido actualizada'], 200);
            } else {
                //Devolvemos una respuesta en caso de que el usuario que intenta editar no existiera
                return response()->json(['errors' => ['Error' => 'El usuario que intenta actualizar no existe']], 422);
            }
        } catch (QueryException $e) {
            //Revertimos los procesos de la BD en caso de cualquier falla al momento de inserción en la BD
            DB::rollBack();
            \Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['Error' => $e->getMessage()]], 422);
        }
    }

    /**
     * Eliminar al usuario usando SoftDelete
     *
     * @param $id_user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteUser($id_user)
    {
        try {
            Agent::where('id', $id_user)->delete();
            return response()->json(['title' => 'Usuario eliminado', 'content' => 'El usuario eliminado ya no tendra acceso al sistema'], 200);
        } catch (QueryException $e) {
            DB::rollBack();
            \Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['Error' => 'No fue posible eliminar al usuario']], 422);
        }
    }


    /**
     * Restaurar al usuario que se haya eliminado (Aún no se a probado)
     *
     * @param $id_user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function restoreUser($id_user)
    {
        try {
            DB::beginTransaction();
            $user = Agent::withTrashed()->where('id', $id_user);
            if ($user->restore()) {
                $user = $user->get()[0];
                try {
                    Mail::send('emails.registro', ['email' => $user->email, 'route' => route('login'), 'name' => $user->name], function ($message) use ($user) {
                        $message->to($user->email)->subject('Restauración del Usuario JAPAM');
                    });
                } catch (Swift_TransportException $ex) {
                    DB::rollBack();
                    return response()->json(['errors' => [$ex->getMessage()]], 422);
                }
                DB::commit();
                return response()->json(['title' => 'Usuario restaurado', 'content' => 'A partir de ahora el usuario volvera a tener acceso al Panel WEB'], 200);
            } else {
                return response()->json(['title' => 'Error', 'content' => 'No fue posible restaurar el Usuario'], 200);
            }
        } catch (QueryException $e) {
            DB::rollBack();
            \Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['Error' => $e->getMessage()]], 422);
        }
    }

    public function update($id, Request $request)
    {
        $this->syncAdministratorCategories($id, $request);

        Session::flash('status', trans('lang.administrators-joined-categories-ok'));

        return redirect()->route('AdministratorsController@index');
    }

    public function destroy($id)
    {
        $administrator = $this->removeAdministrator($id);

        Session::flash('status', trans('lang.administrators-is-removed-from-team', ['name' => $administrator->name]));

        return redirect()->route('AdministratorsController@index');
    }

    /**
     * Assign users as administrators.
     *
     * @param $user_ids
     *
     * @return array
     */
    public function addAdministrators($user_ids)
    {
        $users = Agent::find($user_ids);
        foreach ($users as $user) {
            $user->ticketit_admin = true;
            $user->save();
            $users_list[] = $user->name;
        }

        return $users_list;
    }

    /**
     * Remove user from the administrators.
     *
     * @param $id
     *
     * @return mixed
     */
    public function removeAdministrator($id)
    {
        $administrator = Agent::find($id);
        $administrator->ticketit_admin = false;
        $administrator->save();

        // Remove him from tickets categories as well
        if (version_compare(app()->version(), '5.2.0', '>=')) {
            $administrator_cats = $administrator->categories->pluck('id')->toArray();
        } else { // if Laravel 5.1
            $administrator_cats = $administrator->categories->lists('id')->toArray();
        }

        $administrator->categories()->detach($administrator_cats);

        return $administrator;
    }

    /**
     * Sync Administrator categories with the selected categories got from update form.
     *
     * @param $id
     * @param Request $request
     */
    public function syncAdministratorCategories($id, Request $request)
    {
        $form_cats = ($request->input('administrator_cats') == null) ? [] : $request->input('administrator_cats');
        $administrator = Agent::find($id);
        $administrator->categories()->sync($form_cats);
    }
}
