<?php

namespace App\Http\Controllers;

use DB;
use URL;
use Flash;
use Storage;
use Response;
use App\Http\Requests;
use App\Models\Schedule;
use App\Models\BranchOffice;
use App\Models\BranchOfficeSchedule;
use Illuminate\Database\QueryException;
use App\DataTables\BranchOfficeDataTable;
use App\Http\Controllers\AppBaseController;
use App\Repositories\BranchOfficeRepository;
use App\Http\Requests\CreateBranchOfficeRequest;
use App\Http\Requests\UpdateBranchOfficeRequest;

class BranchOfficeController extends AppBaseController
{
    /** @var  BranchOfficeRepository */
    private $branchOfficeRepository;

    public function __construct(BranchOfficeRepository $branchOfficeRepo)
    {
        $this->branchOfficeRepository = $branchOfficeRepo;
    }

    /**
     * Display a listing of the BranchOffice.
     *
     * @param BranchOfficeDataTable $branchOfficeDataTable
     * @return Response
     */
    public function index(BranchOfficeDataTable $branchOfficeDataTable)
    {
        return $branchOfficeDataTable->render('branch_offices.index');
    }

    /**
     * Show the form for creating a new BranchOffice.
     *
     * @return Response
     */
    public function create()
    {
        return view('branch_offices.create');
    }

    /**
     * Store a newly created BranchOffice in storage.
     *
     * @param CreateBranchOfficeRequest $request
     *
     * @return Response
     */
    public function store(CreateBranchOfficeRequest $request)
    {
        $branchOffice = $request->input('branchOffice');
        $schedule = $request->input('schedule');

        try
        {
            $createBranchOffice = BranchOffice::create([
                'description'=>$branchOffice['description'],
                'street'=>$branchOffice['street'],
                'inside_number'=>$branchOffice['inside_number'],
                'outside_number'=>$branchOffice['outside_number'],
                'settlement'=>$branchOffice['settlement'],
                'cp'=>$branchOffice['cp'],
                'latitude'=>$branchOffice['latitude'],
                'longitude'=>$branchOffice['longitude'],
                'image'=>'without_image',
                'number_phone'=>$branchOffice['number_phone'],
                'extension'=>$branchOffice['extension'],
            ]);

            $branchOfficeId = $createBranchOffice->id;

            $image = explode(',', $branchOffice['image']);
            $imageContent = base64_decode($image[1]);
            $imageName = $branchOfficeId.".".$branchOffice['imageFormat'];
            $imageRoute = 'japam/branch_office/' . $imageName;
            Storage::put($imageRoute, $imageContent);
            $createBranchOffice->image = $imageName;
            $createBranchOffice->save();

            $scheduleCount = count($schedule['area']);
            for ($i = 0; $i < $scheduleCount; $i++)
            {
                $createSchedule = Schedule::create([
                    'area'=>$schedule['area'][$i],
                    'work_day'=>$schedule['work_day'][$i],
                    'begin_time'=>$schedule['begin_time'][$i],
                    'end_time'=>$schedule['end_time'][$i]
                ]);

                $scheduleId = $createSchedule->id;

                BranchOfficeSchedule::create([
                    'branch_office_id'=>$branchOfficeId,
                    'schedule_id'=>$scheduleId
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Sucursal <b>'. $createBranchOffice->description .'</b> creada correctamente.'], 200);
        }catch (QueryException $e) {
            DB::rollback();
            return response()->json(['message' => 'Ocurrió un error al registrar la Sucursal: ' . $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified BranchOffice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $branchOffice = $this->branchOfficeRepository->findWithoutFail($id);

        if (empty($branchOffice)) {
            Flash::error('Branch Office not found');

            return redirect(route('branchOffices.index'));
        }

        return view('branch_offices.show')->with('branchOffice', $branchOffice);
    }

    /**
     * Show the form for editing the specified BranchOffice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $branchOffice = BranchOffice::where('id', $id)->first();

        if (empty($branchOffice)) {
            return response()->json(['message' => 'Sucursal no encontrada.'], 404);
        }

        $path = URL::to('../storage/app/japam/branch_office/'.$branchOffice->image);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $branchOffice->image = $base64;
        $branchOffice->imageFormat = $type;

        $branchOfficeSchedule = BranchOfficeSchedule::where('branch_office_id', $branchOffice->id)
            ->with('schedule')
            ->get();


        $listSchedule = array();
        foreach ($branchOfficeSchedule as $element){
            array_push($listSchedule, $element->schedule);
        }

        return response()->json([
            'message' => 'Datos cargados exitosamente.',
            'branchOffice' => $branchOffice,
            'schedule' => $listSchedule
        ], 200);
    }

    /**
     * Update the specified BranchOffice in storage.
     *
     * @param  int              $id
     * @param UpdateBranchOfficeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBranchOfficeRequest $request)
    {
        $branchOffice = $this->branchOfficeRepository->findWithoutFail($id);

        if (empty($branchOffice)) {
            return response()->json(['message' => 'Sucursal no encontrada, imposible actualizar.'], 404);
        }

        Storage::delete('japam/branch_office/' . $branchOffice->image);

        try {
            $branchOffice->update([
                'description'=>$request->branchOffice['description'],
                'street'=>$request->branchOffice['street'],
                'inside_number'=>$request->branchOffice['inside_number'],
                'outside_number'=>$request->branchOffice['outside_number'],
                'settlement'=>$request->branchOffice['settlement'],
                'cp'=>$request->branchOffice['cp'],
                'latitude'=>$request->branchOffice['latitude'],
                'longitude'=>$request->branchOffice['longitude'],
                'image'=>'without_image',
                'number_phone'=>$request->branchOffice['number_phone'],
                'extension'=>$request->branchOffice['extension'],
            ]);

            $image = explode(',', $request->branchOffice['image']);
            $imageContent = base64_decode($image[1]);
            $imageName = $id.".".$request->branchOffice['imageFormat'];
            $imageRoute = 'japam/branch_office/' . $imageName;
            Storage::put($imageRoute, $imageContent);
            $branchOffice->image = $imageName;
            $branchOffice->save();

            $scheduleCount = count($request->schedule['area']);
            for ($i = 0; $i < $scheduleCount; $i++) {
                $existsSchedule = Schedule::where('id','=', $request->schedule['schedule_id'][$i])->exists();

                if (!$existsSchedule) {
                    $createSchedule = Schedule::create([
                    'area'=>$request->schedule['area'][$i],
                    'work_day'=>$request->schedule['work_day'][$i],
                    'begin_time'=>$request->schedule['begin_time'][$i],
                    'end_time'=>$request->schedule['end_time'][$i]
                    ]);

                    $scheduleId = $createSchedule->id;

                    BranchOfficeSchedule::create([
                        'branch_office_id'=>$branchOffice->id,
                        'schedule_id'=>$scheduleId
                    ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Sucursal <b>'. $branchOffice->description .'</b> actualizada correctamente.'], 200);
        }catch (QueryException $e) {
            DB::rollback();
            return response()->json(['message' => 'Ocurrió un error al actualizar la Sucursal: ' . $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specified BranchOffice from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $branchOffice = $this->branchOfficeRepository->findWithoutFail($id);

        if (empty($branchOffice)) {
            return response()->json(['message' => 'Sucursal no encontrada.'], 404);
        }

        $branchOfficeSchedule = BranchOfficeSchedule::where('branch_office_id', $branchOffice->id)->get();

        if (!empty($branchOfficeSchedule))
        {
            for ($i = 0; $i < count($branchOfficeSchedule); $i++){
                $schedule = Schedule::find($branchOfficeSchedule[$i]->schedule_id);

                $schedule->delete();
            }
        }

        Storage::delete('japam/branch_office/' . $branchOffice->image);
        $this->branchOfficeRepository->delete($id);

        return response()->json(['message' => 'Sucursal eliminada exitosamente.'], 200);
    }

    /**
     * Delete Schedule
     */
    public function deleteSchedule($id){
        $schedule = Schedule::where('id', $id)->first();

        if (empty($schedule)) {
            return response()->json(['message' => 'Error al eliminar, horario no encontrado.'], 404);
        }

        $schedule->delete($id);

        return response()->json(['message' => 'Horario eliminado exitosamente.'], 200);
    }
}
