<?php

namespace App\Http\Controllers;

use App\DataTables\PMOWorkTableFinishDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePMOWorkTableFinishRequest;
use App\Http\Requests\UpdatePMOWorkTableFinishRequest;
use App\Repositories\PMOWorkTableFinishRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PMOWorkTableFinishController extends AppBaseController
{
    /** @var  PMOWorkTableFinishRepository */
    private $pMOWorkTableFinishRepository;

    public function __construct(PMOWorkTableFinishRepository $pMOWorkTableFinishRepo)
    {
        $this->pMOWorkTableFinishRepository = $pMOWorkTableFinishRepo;
    }

    /**
     * Display a listing of the PMOWorkTableFinish.
     *
     * @param PMOWorkTableFinishDataTable $pMOWorkTableFinishDataTable
     * @return Response
     */
    public function index(PMOWorkTableFinishDataTable $pMOWorkTableFinishDataTable)
    {
        return $pMOWorkTableFinishDataTable->render('p_m_o_work_table_finishes.index');
    }

    /**
     * Show the form for creating a new PMOWorkTableFinish.
     *
     * @return Response
     */
    public function create()
    {
        return view('p_m_o_work_table_finishes.create');
    }

    /**
     * Store a newly created PMOWorkTableFinish in storage.
     *
     * @param CreatePMOWorkTableFinishRequest $request
     *
     * @return Response
     */
    public function store(CreatePMOWorkTableFinishRequest $request)
    {
        $input = $request->all();

        $pMOWorkTableFinish = $this->pMOWorkTableFinishRepository->create($input);

        Flash::success('P M O Work Table Finish saved successfully.');

        return redirect(route('pMOWorkTableFinishes.index'));
    }

    /**
     * Display the specified PMOWorkTableFinish.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pMOWorkTableFinish = $this->pMOWorkTableFinishRepository->findWithoutFail($id);

        if (empty($pMOWorkTableFinish)) {
            Flash::error('P M O Work Table Finish not found');

            return redirect(route('pMOWorkTableFinishes.index'));
        }

        return view('p_m_o_work_table_finishes.show')->with('pMOWorkTableFinish', $pMOWorkTableFinish);
    }

    /**
     * Show the form for editing the specified PMOWorkTableFinish.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pMOWorkTableFinish = $this->pMOWorkTableFinishRepository->findWithoutFail($id);

        if (empty($pMOWorkTableFinish)) {
            Flash::error('P M O Work Table Finish not found');

            return redirect(route('pMOWorkTableFinishes.index'));
        }

        return view('p_m_o_work_table_finishes.edit')->with('pMOWorkTableFinish', $pMOWorkTableFinish);
    }

    /**
     * Update the specified PMOWorkTableFinish in storage.
     *
     * @param  int              $id
     * @param UpdatePMOWorkTableFinishRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePMOWorkTableFinishRequest $request)
    {
        $pMOWorkTableFinish = $this->pMOWorkTableFinishRepository->findWithoutFail($id);

        if (empty($pMOWorkTableFinish)) {
            Flash::error('P M O Work Table Finish not found');

            return redirect(route('pMOWorkTableFinishes.index'));
        }

        $pMOWorkTableFinish = $this->pMOWorkTableFinishRepository->update($request->all(), $id);

        Flash::success('P M O Work Table Finish updated successfully.');

        return redirect(route('pMOWorkTableFinishes.index'));
    }

    /**
     * Remove the specified PMOWorkTableFinish from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pMOWorkTableFinish = $this->pMOWorkTableFinishRepository->findWithoutFail($id);

        if (empty($pMOWorkTableFinish)) {
            Flash::error('P M O Work Table Finish not found');

            return redirect(route('pMOWorkTableFinishes.index'));
        }

        $this->pMOWorkTableFinishRepository->delete($id);

        Flash::success('P M O Work Table Finish deleted successfully.');

        return redirect(route('pMOWorkTableFinishes.index'));
    }
}
