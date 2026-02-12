<?php

namespace App\Http\Controllers\Api;

use App\DataTables\PMOEquipmentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePMOEquipmentRequest;
use App\Http\Requests\UpdatePMOEquipmentRequest;
use App\Models\PMOEquipment;
use App\Repositories\PMOEquipmentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PMOEquipmentController extends AppBaseController
{
    /** @var  PMOEquipmentRepository */
    private $pMOEquipmentRepository;

    public function __construct(PMOEquipmentRepository $pMOEquipmentRepo)
    {
        $this->pMOEquipmentRepository = $pMOEquipmentRepo;
    }

    /**
     * Display a listing of the PMOEquipment.
     *
     * @param PMOEquipmentDataTable $pMOEquipmentDataTable
     * @return Response
     */
    public function index(PMOEquipmentDataTable $pMOEquipmentDataTable)
    {
        $equipo = PMOEquipment::query()->paginate(15);

        return response()->json(array($equipo),200);
    }

    /**
     * Show the form for creating a new PMOEquipment.
     *
     * @return Response
     */
    public function create()
    {
        return view('p_m_o_equipments.create');
    }

    /**
     * Store a newly created PMOEquipment in storage.
     *
     * @param CreatePMOEquipmentRequest $request
     *
     * @return Response
     */
    public function store(CreatePMOEquipmentRequest $request)
    {
        $input = $request->all();

        $pMOEquipment = $this->pMOEquipmentRepository->create($input);

        return response()->json(array("success"=>1,"pMOEquipment"=>$pMOEquipment));
    }

    /**
     * Display the specified PMOEquipment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pMOEquipment = $this->pMOEquipmentRepository->findWithoutFail($id);

        if (empty($pMOEquipment)) {
            Flash::error('P M O Equipment not found');

            return redirect(route('pMOEquipments.index'));
        }

        return view('p_m_o_equipments.show')->with('pMOEquipment', $pMOEquipment);
    }

    /**
     * Show the form for editing the specified PMOEquipment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pMOEquipment = $this->pMOEquipmentRepository->findWithoutFail($id);

        if (empty($pMOEquipment)) {
            return response()->json(array("success"=>0,"msg"=>"No se encontró el ID"));
        }

        return response()->json(array("success"=>1,"pMOEquipment"=>$pMOEquipment));
    }

    /**
     * Update the specified PMOEquipment in storage.
     *
     * @param  int              $id
     * @param UpdatePMOEquipmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePMOEquipmentRequest $request)
    {
        $pMOEquipment = $this->pMOEquipmentRepository->findWithoutFail($id);

        if (empty($pMOEquipment)) {
            return response()->json(array("success"=>0,"msg"=>"No se encontró el ID"));
        }

        $pMOEquipment = $this->pMOEquipmentRepository->update($request->all(), $id);

        return response()->json(array("success"=>1,"pMOEquipment"=>$pMOEquipment));
    }

    /**
     * Remove the specified PMOEquipment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pMOEquipment = $this->pMOEquipmentRepository->findWithoutFail($id);

        if (empty($pMOEquipment)) {
            Flash::error('P M O Equipment not found');

            return redirect(route('pMOEquipments.index'));
        }

        $this->pMOEquipmentRepository->delete($id);

        Flash::success('P M O Equipment deleted successfully.');

        return redirect(route('pMOEquipments.index'));
    }
}
