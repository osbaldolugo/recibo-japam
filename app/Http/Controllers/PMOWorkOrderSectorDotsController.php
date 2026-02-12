<?php

namespace App\Http\Controllers;

use App\DataTables\PMOWorkOrderSectorDotsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePMOWorkOrderSectorDotsRequest;
use App\Http\Requests\UpdatePMOWorkOrderSectorDotsRequest;
use App\Repositories\PMOWorkOrderSectorDotsRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PMOWorkOrderSectorDotsController extends AppBaseController
{
    /** @var  PMOWorkOrderSectorDotsRepository */
    private $pMOWorkOrderSectorDotsRepository;

    public function __construct(PMOWorkOrderSectorDotsRepository $pMOWorkOrderSectorDotsRepo)
    {
        $this->pMOWorkOrderSectorDotsRepository = $pMOWorkOrderSectorDotsRepo;
    }

    /**
     * Display a listing of the PMOWorkOrderSectorDots.
     *
     * @param PMOWorkOrderSectorDotsDataTable $pMOWorkOrderSectorDotsDataTable
     * @return Response
     */
    public function index(PMOWorkOrderSectorDotsDataTable $pMOWorkOrderSectorDotsDataTable)
    {
        return $pMOWorkOrderSectorDotsDataTable->render('p_m_o_work_order_sector_dots.index');
    }

    /**
     * Show the form for creating a new PMOWorkOrderSectorDots.
     *
     * @return Response
     */
    public function create()
    {
        return view('p_m_o_work_order_sector_dots.create');
    }

    /**
     * Store a newly created PMOWorkOrderSectorDots in storage.
     *
     * @param CreatePMOWorkOrderSectorDotsRequest $request
     *
     * @return Response
     */
    public function store(CreatePMOWorkOrderSectorDotsRequest $request)
    {
        $input = $request->all();

        $pMOWorkOrderSectorDots = $this->pMOWorkOrderSectorDotsRepository->create($input);

        Flash::success('P M O Work Order Sector Dots saved successfully.');

        return redirect(route('pMOWorkOrderSectorDots.index'));
    }

    /**
     * Display the specified PMOWorkOrderSectorDots.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pMOWorkOrderSectorDots = $this->pMOWorkOrderSectorDotsRepository->findWithoutFail($id);

        if (empty($pMOWorkOrderSectorDots)) {
            Flash::error('P M O Work Order Sector Dots not found');

            return redirect(route('pMOWorkOrderSectorDots.index'));
        }

        return view('p_m_o_work_order_sector_dots.show')->with('pMOWorkOrderSectorDots', $pMOWorkOrderSectorDots);
    }

    /**
     * Show the form for editing the specified PMOWorkOrderSectorDots.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pMOWorkOrderSectorDots = $this->pMOWorkOrderSectorDotsRepository->findWithoutFail($id);

        if (empty($pMOWorkOrderSectorDots)) {
            Flash::error('P M O Work Order Sector Dots not found');

            return redirect(route('pMOWorkOrderSectorDots.index'));
        }

        return view('p_m_o_work_order_sector_dots.edit')->with('pMOWorkOrderSectorDots', $pMOWorkOrderSectorDots);
    }

    /**
     * Update the specified PMOWorkOrderSectorDots in storage.
     *
     * @param  int              $id
     * @param UpdatePMOWorkOrderSectorDotsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePMOWorkOrderSectorDotsRequest $request)
    {
        $pMOWorkOrderSectorDots = $this->pMOWorkOrderSectorDotsRepository->findWithoutFail($id);

        if (empty($pMOWorkOrderSectorDots)) {
            Flash::error('P M O Work Order Sector Dots not found');

            return redirect(route('pMOWorkOrderSectorDots.index'));
        }

        $pMOWorkOrderSectorDots = $this->pMOWorkOrderSectorDotsRepository->update($request->all(), $id);

        Flash::success('P M O Work Order Sector Dots updated successfully.');

        return redirect(route('pMOWorkOrderSectorDots.index'));
    }

    /**
     * Remove the specified PMOWorkOrderSectorDots from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pMOWorkOrderSectorDots = $this->pMOWorkOrderSectorDotsRepository->findWithoutFail($id);

        if (empty($pMOWorkOrderSectorDots)) {
            Flash::error('P M O Work Order Sector Dots not found');

            return redirect(route('pMOWorkOrderSectorDots.index'));
        }

        $this->pMOWorkOrderSectorDotsRepository->delete($id);

        Flash::success('P M O Work Order Sector Dots deleted successfully.');

        return redirect(route('pMOWorkOrderSectorDots.index'));
    }
}
