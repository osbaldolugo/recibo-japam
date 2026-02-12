<?php

namespace App\Http\Controllers\Api;

use App\DataTables\PMOWorkerDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePMOWorkerRequest;
use App\Http\Requests\UpdatePMOWorkerRequest;
use App\Models\PMOSpeciality;
use App\Repositories\PMOWorkerRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PMOWorkerController extends AppBaseController
{
    /** @var  PMOWorkerRepository */
    private $pMOWorkerRepository;

    public function __construct(PMOWorkerRepository $pMOWorkerRepo)
    {
        $this->pMOWorkerRepository = $pMOWorkerRepo;
    }

    /**
     * Display a listing of the PMOWorker.
     *
     * @param PMOWorkerDataTable $pMOWorkerDataTable
     * @return Response
     */
    public function index(PMOWorkerDataTable $pMOWorkerDataTable)
    {
        $specialities = PMOSpeciality::pluck("speciality","id");
        return $pMOWorkerDataTable->render('p_m_o_workers.index',compact("specialities"));
    }

    /**
     * Show the form for creating a new PMOWorker.
     *
     * @return Response
     */
    public function create()
    {
        return view('p_m_o_workers.create');
    }

    /**
     * Store a newly created PMOWorker in storage.
     *
     * @param CreatePMOWorkerRequest $request
     *
     * @return Response
     */
    public function store(CreatePMOWorkerRequest $request)
    {
        $input = $request->all();

        $pMOWorker = $this->pMOWorkerRepository->create($input);

        return response()->json(array("success"=>1,"pMOWorker"=>$pMOWorker));
    }

    /**
     * Display the specified PMOWorker.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pMOWorker = $this->pMOWorkerRepository->findWithoutFail($id);

        if (empty($pMOWorker)) {
            Flash::error('P M O Worker not found');

            return redirect(route('pMOWorkers.index'));
        }

        return view('p_m_o_workers.show')->with('pMOWorker', $pMOWorker);
    }

    /**
     * Show the form for editing the specified PMOWorker.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pMOWorker = $this->pMOWorkerRepository->findWithoutFail($id);

        if (empty($pMOWorker)) {
            return response()->json(array("success"=>0,"msg"=>"No se encuentró el ID"));
        }

        return response()->json(array("success"=>1,"pMOWorker"=>$pMOWorker));
    }

    /**
     * Update the specified PMOWorker in storage.
     *
     * @param  int              $id
     * @param UpdatePMOWorkerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePMOWorkerRequest $request)
    {
        $pMOWorker = $this->pMOWorkerRepository->findWithoutFail($id);

        if (empty($pMOWorker)) {
            return response()->json(array("success"=>0,"msg"=>"No se encontró el ID"));
        }

        $pMOWorker = $this->pMOWorkerRepository->update($request->all(), $id);

        return response()->json(array("success"=>1,"pMOWorker"=>$pMOWorker));
    }

    /**
     * Remove the specified PMOWorker from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pMOWorker = $this->pMOWorkerRepository->findWithoutFail($id);

        if (empty($pMOWorker)) {
            Flash::error('P M O Worker not found');

            return redirect(route('pMOWorkers.index'));
        }

        $this->pMOWorkerRepository->delete($id);

        Flash::success('P M O Worker deleted successfully.');

        return redirect(route('pMOWorkers.index'));
    }
}
