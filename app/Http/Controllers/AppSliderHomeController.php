<?php

namespace App\Http\Controllers;

use DB;
use URL;
use Flash;
use Storage;
use Response;
use App\Http\Requests;
use App\Models\AppSliderHome;
use Illuminate\Database\QueryException;
use App\DataTables\AppSliderHomeDataTable;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AppSliderHomeRepository;
use App\Http\Requests\CreateAppSliderHomeRequest;
use App\Http\Requests\UpdateAppSliderHomeRequest;

class AppSliderHomeController extends AppBaseController
{
    /** @var  AppSliderHomeRepository */
    private $appSliderHomeRepository;

    public function __construct(AppSliderHomeRepository $appSliderHomeRepo)
    {
        $this->appSliderHomeRepository = $appSliderHomeRepo;
    }

    /**
     * Display a listing of the AppSliderHome.
     *
     * @param AppSliderHomeDataTable $appSliderHomeDataTable
     * @return Response
     */
    public function index(AppSliderHomeDataTable $appSliderHomeDataTable)
    {
        return $appSliderHomeDataTable->render('app_slider_homes.index');
    }

    /**
     * Show the form for creating a new AppSliderHome.
     *
     * @return Response
     */
    public function create()
    {
        return view('app_slider_homes.create');
    }

    /**
     * Store a newly created AppSliderHome in storage.
     *
     * @param CreateAppSliderHomeRequest $request
     *
     * @return Response
     */
    public function store(CreateAppSliderHomeRequest $request)
    {
        $appSliderHome = $request->input('appSliderHome');

        try
        {
            $createAppSliderHome = AppSliderHome::create([
                'image' => 'without_image',
                'status' => $appSliderHome['status']
            ]);

            $appSliderHomeId = $createAppSliderHome->id;

            $image = explode(',', $appSliderHome['image']);
            $imageContent = base64_decode($image[1]);
            $imageName = $appSliderHomeId.".".$appSliderHome['imageFormat'];
            $imageRoute = 'japam/app_slider_home/' . $imageName;
            Storage::put($imageRoute, $imageContent);
            $createAppSliderHome->image = $imageName;
            $createAppSliderHome->save();

            DB::commit();
            return response()->json(['message' => 'Imágen guardada correctamente.'], 200);
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json(['message' => 'Ocurrió un error al guardar la imágen: ' . $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified AppSliderHome.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $appSliderHome = $this->appSliderHomeRepository->findWithoutFail($id);

        if (empty($appSliderHome)) {
            Flash::error('App Slider Home not found');

            return redirect(route('appSliderHomes.index'));
        }

        return view('app_slider_homes.show')->with('appSliderHome', $appSliderHome);
    }

    /**
     * Show the form for editing the specified AppSliderHome.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $appSliderHome = $this->appSliderHomeRepository->findWithoutFail($id);

        if (empty($appSliderHome)) {
            Flash::error('App Slider Home not found');

            return redirect(route('appSliderHomes.index'));
        }

        return view('app_slider_homes.edit')->with('appSliderHome', $appSliderHome);
    }

    /**
     * Update the specified AppSliderHome in storage.
     *
     * @param  int              $id
     * @param UpdateAppSliderHomeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppSliderHomeRequest $request)
    {
        $request = $request->input('appSliderHome');
        $appSliderHome = $this->appSliderHomeRepository->findWithoutFail($id);

        if (empty($appSliderHome)) {
            return response()->json(['message' => 'Registro no encontrado. Imposible actualizar'], 404);
        }

        if ($appSliderHome->status != $request['status']) {
            $appSliderHome->update(['status'=>$request['status']]);
            $appSliderHome->save();

            return response()->json(['message' => 'Actualizado correctamente.'], 200);
        }

        return response()->json(['message' => null], 200);
    }

    /**
     * Remove the specified AppSliderHome from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $appSliderHome = $this->appSliderHomeRepository->findWithoutFail($id);

        if (empty($appSliderHome)) {
            return response()->json(['message' => 'Imágen no encontrada.'], 404);
        }

        Storage::delete('japam/app_slider_home/' . $appSliderHome->image);
        $this->appSliderHomeRepository->delete($id);

        return response()->json(['message' => 'Imágen eliminada exitosamente.'], 200);
    }
    /**
     * Load image for id.
     *
     * @return Response
     */
    public function getImage($id)
    {
        $appSliderHome = AppSliderHome::find($id);

        if (empty($appSliderHome)) {
            return response()->json(['message' => 'Imágen no encontrada.'], 404);
        }

        $path = URL::to('../storage/app/japam/app_slider_home/'.$appSliderHome->image);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $appSliderHome->image = $base64;

        return response()->json(['image' => $appSliderHome], 200);
    }
    /**
     * Load images from storage.
     *
     * @return Response
     */
    public function sliderLoad()
    {
        $appSliderHome = AppSliderHome::all();

        if (empty($appSliderHome)) {
            return response()->json(['message' => 'No hay imágenes almacenadas en el servidor.'], 404);
        }

        $imagesCount = count($appSliderHome);
        for ($i = 0; $i < $imagesCount; $i++){
            $path = URL::to('../storage/app/japam/app_slider_home/'.$appSliderHome[$i]->image);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $appSliderHome[$i]->image = $base64;
        }

        $images = $appSliderHome->where('status', '!=', 'deshabilitada');

        return response()->json(['message' => 'Imágenes cargadas correctamente.', 'images' => $images], 200);
    }
}
