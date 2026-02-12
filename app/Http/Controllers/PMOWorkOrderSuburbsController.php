<?php

namespace App\Http\Controllers;

use App\DataTables\PMOWorkOrderSuburbsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePMOWorkOrderSuburbsRequest;
use App\Http\Requests\UpdatePMOWorkOrderSuburbsRequest;
use App\Repositories\PMOWorkOrderSuburbsRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PMOWorkOrderSuburbsController extends AppBaseController
{
    /** @var  PMOWorkOrderSuburbsRepository */
    private $pMOWorkOrderSuburbsRepository;

    public function __construct(PMOWorkOrderSuburbsRepository $pMOWorkOrderSuburbsRepo)
    {
        $this->pMOWorkOrderSuburbsRepository = $pMOWorkOrderSuburbsRepo;
    }

    /**
     * Display a listing of the PMOWorkOrderSuburbs.
     *
     * @param PMOWorkOrderSuburbsDataTable $pMOWorkOrderSuburbsDataTable
     * @return Response
     */
    public function index(PMOWorkOrderSuburbsDataTable $pMOWorkOrderSuburbsDataTable)
    {
        return $pMOWorkOrderSuburbsDataTable->render('p_m_o_work_order_suburbs.index');
    }

    /**
     * Show the form for creating a new PMOWorkOrderSuburbs.
     *
     * @return Response
     */
    public function create()
    {
        return view('p_m_o_work_order_suburbs.create');
    }

    /**
     * Store a newly created PMOWorkOrderSuburbs in storage.
     *
     * @param CreatePMOWorkOrderSuburbsRequest $request
     *
     * @return Response
     */
    public function store(CreatePMOWorkOrderSuburbsRequest $request)
    {
        $input = $request->all();

        $pMOWorkOrderSuburbs = $this->pMOWorkOrderSuburbsRepository->create($input);

        Flash::success('P M O Work Order Suburbs saved successfully.');

        return redirect(route('pMOWorkOrderSuburbs.index'));
    }

    /**
     * Display the specified PMOWorkOrderSuburbs.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pMOWorkOrderSuburbs = $this->pMOWorkOrderSuburbsRepository->findWithoutFail($id);

        if (empty($pMOWorkOrderSuburbs)) {
            Flash::error('P M O Work Order Suburbs not found');

            return redirect(route('pMOWorkOrderSuburbs.index'));
        }

        return view('p_m_o_work_order_suburbs.show')->with('pMOWorkOrderSuburbs', $pMOWorkOrderSuburbs);
    }

    /**
     * Show the form for editing the specified PMOWorkOrderSuburbs.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pMOWorkOrderSuburbs = $this->pMOWorkOrderSuburbsRepository->findWithoutFail($id);

        if (empty($pMOWorkOrderSuburbs)) {
            Flash::error('P M O Work Order Suburbs not found');

            return redirect(route('pMOWorkOrderSuburbs.index'));
        }

        return view('p_m_o_work_order_suburbs.edit')->with('pMOWorkOrderSuburbs', $pMOWorkOrderSuburbs);
    }

    /**
     * Update the specified PMOWorkOrderSuburbs in storage.
     *
     * @param  int              $id
     * @param UpdatePMOWorkOrderSuburbsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePMOWorkOrderSuburbsRequest $request)
    {
        $pMOWorkOrderSuburbs = $this->pMOWorkOrderSuburbsRepository->findWithoutFail($id);

        if (empty($pMOWorkOrderSuburbs)) {
            Flash::error('P M O Work Order Suburbs not found');

            return redirect(route('pMOWorkOrderSuburbs.index'));
        }

        $pMOWorkOrderSuburbs = $this->pMOWorkOrderSuburbsRepository->update($request->all(), $id);

        Flash::success('P M O Work Order Suburbs updated successfully.');

        return redirect(route('pMOWorkOrderSuburbs.index'));
    }

    /**
     * Remove the specified PMOWorkOrderSuburbs from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pMOWorkOrderSuburbs = $this->pMOWorkOrderSuburbsRepository->findWithoutFail($id);

        if (empty($pMOWorkOrderSuburbs)) {
            Flash::error('P M O Work Order Suburbs not found');

            return redirect(route('pMOWorkOrderSuburbs.index'));
        }

        $this->pMOWorkOrderSuburbsRepository->delete($id);

        Flash::success('P M O Work Order Suburbs deleted successfully.');

        return redirect(route('pMOWorkOrderSuburbs.index'));
    }
}
