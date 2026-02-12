<?php

namespace App\Http\Controllers\Api;

use App\DataTables\PMOWorkDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePMOWorkRequest;
use App\Http\Requests\UpdatePMOWorkRequest;
use App\Repositories\PMOWorkRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PMOWorkController extends AppBaseController
{
    /** @var  PMOWorkRepository */
    private $pMOWorkRepository;

    public function __construct(PMOWorkRepository $pMOWorkRepo)
    {
        $this->pMOWorkRepository = $pMOWorkRepo;
    }

    /**
     * Display a listing of the PMOWork.
     *
     * @param PMOWorkDataTable $pMOWorkDataTable
     * @return Response
     */
    public function index(PMOWorkDataTable $pMOWorkDataTable)
    {
        return $pMOWorkDataTable->render('p_m_o_works.index');
    }

    /**
     * Show the form for creating a new PMOWork.
     *
     * @return Response
     */
    public function create()
    {
        return view('p_m_o_works.create');
    }

    /**
     * Store a newly created PMOWork in storage.
     *
     * @param CreatePMOWorkRequest $request
     *
     * @return Response
     */
    public function store(CreatePMOWorkRequest $request)
    {
        $input = $request->all();

        $pMOWork = $this->pMOWorkRepository->create($input);

        Flash::success('P M O Work saved successfully.');

        return redirect(route('pMOWorks.index'));
    }

    /**
     * Display the specified PMOWork.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pMOWork = $this->pMOWorkRepository->findWithoutFail($id);

        if (empty($pMOWork)) {
            Flash::error('P M O Work not found');

            return redirect(route('pMOWorks.index'));
        }

        return view('p_m_o_works.show')->with('pMOWork', $pMOWork);
    }

    /**
     * Show the form for editing the specified PMOWork.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pMOWork = $this->pMOWorkRepository->findWithoutFail($id);

        if (empty($pMOWork)) {
            Flash::error('P M O Work not found');

            return response()->json(array("success"=>0,"msg"=>"No se encontró ID"));
        }

        return response()->json(array("success"=>1,"work"=>$pMOWork));
    }

    /**
     * Update the specified PMOWork in storage.
     *
     * @param  int              $id
     * @param UpdatePMOWorkRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePMOWorkRequest $request)
    {
        $pMOWork = $this->pMOWorkRepository->findWithoutFail($id);

        if (empty($pMOWork)) {
            Flash::error('P M O Work not found');

            return redirect(route('pMOWorks.index'));
        }

        $pMOWork = $this->pMOWorkRepository->update($request->all(), $id);

        Flash::success('P M O Work updated successfully.');

        return redirect(route('pMOWorks.index'));
    }

    /**
     * Remove the specified PMOWork from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pMOWork = $this->pMOWorkRepository->findWithoutFail($id);

        if (empty($pMOWork)) {
            Flash::error('P M O Work not found');

            return redirect(route('pMOWorks.index'));
        }

        $this->pMOWorkRepository->delete($id);

        Flash::success('P M O Work deleted successfully.');

        return redirect(route('pMOWorks.index'));
    }
}
