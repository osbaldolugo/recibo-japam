<?php

namespace App\Http\Controllers;

use App\DataTables\AppUserDataTable;
use App\Http\Requests\CreatePeopleRequest;
use App\Http\Requests\CreateAppUserRequest;
use App\Http\Requests\CreateReceiptRequest;
use App\Http\Requests\UpdateAppUserRequest;
use App\Libraries\ApiJapam;
use App\Models\AppUser;
use App\Models\People;
use App\Models\Receipt;
use App\Repositories\AppUserRepository;
use DB;
use Flash;
use Mail;
use App\Http\Controllers\AppBaseController;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Response;
use Swift_TransportException;

class AppUserController extends AppBaseController
{
    /** @var  AppUserRepository */
    private $appUserRepository;

    public function __construct(AppUserRepository $appUserRepo)
    {
        $this->appUserRepository = $appUserRepo;
    }

    /**
     * Display a listing of the AppUser.
     *
     * @param AppUserDataTable $appUserDataTable
     * @return Response
     */
    public function index(AppUserDataTable $appUserDataTable)
    {
        return $appUserDataTable->render('app_users.index');
    }

    /**
     * Show the form for creating a new AppUser.
     *
     * @return Response
     */
    public function create()
    {
        return view('app_users.create');
    }

    /**
     * Store a newly created AppUser in storage.
     *
     * @param CreateAppUserRequest $request
     *
     * @return Response
     */
    public function store(CreateAppUserRequest $request)
    {
        $input = $request->all();

        $appUser = $this->appUserRepository->create($input);

        Flash::success('App User saved successfully.');

        return redirect(route('appUsers.index'));
    }

    /**
     * Display the specified AppUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $appUser = $this->appUserRepository->findWithoutFail($id);

        if (empty($appUser)) {
            Flash::error('App User not found');

            return redirect(route('appUsers.index'));
        }

        return view('app_users.show')->with('appUser', $appUser);
    }

    /**
     * Show the form for editing the specified AppUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $appUser = $this->appUserRepository->findWithoutFail($id);

        if (empty($appUser)) {
            Flash::error('App User not found');

            return redirect(route('appUsers.index'));
        }

        return view('app_users.edit')->with('appUser', $appUser);
    }

    /**
     * Update the specified AppUser in storage.
     *
     * @param  int $id
     * @param UpdateAppUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppUserRequest $request)
    {
        $appUser = $this->appUserRepository->findWithoutFail($id);

        if (empty($appUser)) {
            Flash::error('App User not found');

            return redirect(route('appUsers.index'));
        }

        $appUser = $this->appUserRepository->update($request->all(), $id);

        Flash::success('App User updated successfully.');

        return redirect(route('appUsers.index'));
    }

    /**
     * Remove the specified AppUser from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $appUser = $this->appUserRepository->findWithoutFail($id);

        if (empty($appUser)) {
            Flash::error('App User not found');

            return redirect(route('appUsers.index'));
        }

        $this->appUserRepository->delete($id);

        Flash::success('App User deleted successfully.');

        return redirect(route('appUsers.index'));
    }

    //----------------- REGISTER Vive el reto ------------------------

    /**
     * Save the 'Vive el reto' register
     *
     * @param CreatePeopleRequest $createPeopleRequest
     * @param CreateAppUserRequest $createAppUserRequest
     * @param CreateReceiptRequest $createReceiptRequest
     *
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function saveRegisterViveReto(CreatePeopleRequest $createPeopleRequest, CreateAppUserRequest $createAppUserRequest, CreateReceiptRequest $createReceiptRequest)
    {
        $inputRequest = $createPeopleRequest->all();
        $apiJapam = new ApiJapam();
        $isValidContract = $apiJapam->validateContract($inputRequest['contract'], $inputRequest['barcode']);
        if ($isValidContract == null) {
            return response()->json(["errors" => ["contract" => "La información ingresada es invalida."]])->setStatusCode(422);
        } else {
            if (!isset($inputRequest['holder'])) {//Validamos manualmente la información del contacto del recibo
                if (empty($inputRequest['name_u']))
                    return response()->json(['errors' => ['Nombre de Contacto' => 'Es necesario establecer el nombre del contacto']], 422);
                elseif (empty($inputRequest['last_name_1_u']))
                    return response()->json(['errors' => ['Apellido Paterno' => 'Es necesario establecer el apellido paterno del contacto']], 422);
            }
            try {
                $user = AppUser::where('email', $inputRequest['email'])->get()->first(); //Buscamos si la la persona ya se encuentra registrada
                if (empty($user)) {
                    $owner = Receipt::where('contract', $inputRequest['contract'])->where('barcode', $inputRequest['barcode'])->get()->first(); //Buscamos si el recibo ya se encunetra registrado
                    DB::beginTransaction();
                    if (empty($owner)) { //En caso de que el recibo no se encuentre registrado
                        $owner = Receipt::create([
                            'contract' => $inputRequest['contract'],
                            'barcode' => $inputRequest['barcode']
                        ]);
                    }
                    if (isset($inputRequest['holder'])) {
                        $person = People::updateOrCreate(['name' => $inputRequest['name']], ['name' => $inputRequest['name']]);
                    } else {
                        $requestPeople = [
                            'name' => $inputRequest['name_u'],
                            'last_name_1' => $inputRequest['last_name_1_u'],
                            'last_name_2' => $inputRequest['last_name_2_u']
                        ];
                        $person = People::updateOrCreate($requestPeople, $requestPeople);
                    }
                    $user = $person->user()->create([
                        'email' => $inputRequest['email'],
                        'password' => bcrypt($inputRequest['password']),
                        'phone_number' => $inputRequest['phone_number'],
                        'acceptChallenge' => 1,
                        'verify_token' => AppUser::generateToken()
                    ]);
                    $owner->user()->attach($user);//Creamos la relación entre el titular y el usuario
                    $sendEmail = self::sendEmail($person->name, $user->email, $user->verify_token);
                    if ($sendEmail['email_send']) {
                        DB::commit();
                        return response()->json(['success' => 1, 'msg' => '¡Gracias por concluir tu registro excitosamente!¡Muy pronto recibiras un correo electrónico de confirmación!', 'question' => 'HOLA ' . strtoupper($person->name)]);
                    } else {
                        DB::rollBack();
                        \Log::error($sendEmail['error_message']);
                        return response()->json(['errors' => ['Error' => 'Lo sentimos, pero no fue posible completar su registro, hubo un problema al intentar comunicarnos con el servidor']], 422);
                    }
                } else {
                    return response()->json(['msg' => 'Para ingresar a su cuenta de click en Login', 'question' => 'Usted ya ha registrado su cuenta', 'route' => route('appUser.login.view')], 200);
                }
            } catch (QueryException $e) {
                DB::rollBack();
                \Log::error($e->getMessage());
                return response()->json(["errors" => ['Error' => 'Lo sentimos, pero no fue posible completar su registro, hubo un problema al intentar enviar la información al servidor']], 422);
            }
        }
    }

    /**
     * @param $contract
     * @param $barcode
     *
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function getNameOwner($contract, $barcode)
    {
        $apiJapam = new ApiJapam();
        $isValidContract = $apiJapam->validateContract($contract, $barcode);

        if ($isValidContract == null) {
            return response()->json(["errors" => ["Contrato" => "La información ingresada es inválida.", "Codigo de barras" => "La información ingresada es inválida."]])->setStatusCode(422);
        } else {
            $receipt = $apiJapam->receiptGeneralDetails($contract, $barcode);
            if (count($receipt) == 0) {
                return response()->json(["errors" => ["Contrato" => "La información ingresada es inválida."]])->setStatusCode(422);
            }
            return response()->json(["name" => $receipt["name"]], 200);
        }
    }

    //----------------- END REGISTER Vive el reto ------------------------

    public static function sendEmail($name, $email, $token)
    {
        $url = route('verifyEmail', ['token' => $token, 'email' => base64_encode($email)]);

        try {
            Mail::send('auth.emails.auth_user_email', ['name' => $name, 'url' => $url], function ($messages) use ($email) {
                $messages->to($email)->subject('JAPAM activa tu cuenta');
            });
            return ['email_send' => true];
        } catch (Swift_TransportException $e) {
            
            \Log::error('AppUserController [sendEmail]: ' . $e->getMessage());
            return ['email_send' => false, 'error_message' => $e->getMessage(), 'error_code' => $e->getCode()];
        }
    }

    public function verifyEMail($token, $email = null)
    {
        $app_user = AppUser::with('people')->where('verify_token', $token)->get()->first();
        if ($app_user) {
            try {
                DB::beginTransaction();
                $app_user->activated = 1;
                $app_user->verify_token = $app_user->generateToken();
                $app_user->save();
                $name = $app_user->people != null ? trim($app_user->people->name . ' ' . $app_user->people->last_name_1 . ' ' . $app_user->people->last_name_2) : 'ANÓNIMO';
//                $receipt = $app_user->receipts != null ? $app_user->receipts[0]->contract : null;
                $sendEmail = $this->sendEmailInformation($name, base64_decode($email));
                if ($sendEmail['email_send']) {
                    $activado = 1;
                    $title = '!Su cuenta se ha activado!';
                    DB::commit();
                } else {
                    $activado = 0;
                    $title = '!El servidor no ha respondido!';
                    DB::rollBack();
                }
                return view('app_users.verifyEmail')->with(['name' => $name, 'activado' => $activado, 'title' => $title]);
            } catch (QueryException $e) {
                DB::rollBack();
                \Log::error('Code:' . $e->getCode() . ' Error:' . $e->getMessage());
                return view('app_users.verifyEmail')->with(['activado' => 0, 'title' => '!El servidor no ha respondido!']);
            }
        } else {
            return view('app_users.verifyEmail')->with(['activado' => 3, 'title' => '!El código de activación no es válido!']); //Su código de activación no es válido
        }
    }

    public function sendEmailInformation($name, $email)
    {
        try {
            Mail::send('emails.ViveRetoRegistro', ['name' => $name, 'contract' => null, 'japam_web' => route('appUser.login.view')], function ($message) use ($email) {
                $message->to($email)->subject('JAPAM activa tu cuenta');
            });
            return ['email_send' => true];
        } catch (Swift_TransportException $ex) { //En caso de que el correo no haya salido devolvemos un mesaje de error y anulamos la inserción de los datos
            \Log::error($ex->getMessage());
            return ['email_send' => false, 'error_message' => $ex->getMessage(), 'error_code' => $ex->getCode()];
//            return response()->json(['success' => 0, 'msg' => 'Lo sentimos, pero no fue posible completar su registro, hubo un problema al intentar comunicarnos con el servidor']);
        }
    }


    public function userProfile(){
        return view('user_panel.user-profile');
    }
}
