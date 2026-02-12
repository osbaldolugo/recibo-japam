<?php

namespace App\Http\Controllers\Api;

use App\DataTables\AppTicketDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAppTicketRequest;
use App\Http\Requests\UpdateAppTicketRequest;
use App\Repositories\AppTicketRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AppTicketController extends AppBaseController
{
    /** @var  AppTicketRepository */
    private $appTicketRepository;

    public function __construct(AppTicketRepository $appTicketRepo)
    {
        $this->appTicketRepository = $appTicketRepo;
    }

    /**
     * Display a listing of the AppTicket.
     *
     * @param AppTicketDataTable $appTicketDataTable
     * @return Response
     */
    public function index(AppTicketDataTable $appTicketDataTable)
    {
        return $appTicketDataTable->render('app_tickets.index');
    }

    /**
     * Show the form for creating a new AppTicket.
     *
     * @return Response
     */
    public function create()
    {
        return view('app_tickets.create');
    }

    /**
     * Store a newly created AppTicket in storage.
     *
     * @param CreateAppTicketRequest $request
     *
     * @return Response
     */
    public function store(CreateAppTicketRequest $request)
    {
        $input = $request->all();

        $appTicket = $this->appTicketRepository->create($input);

        Flash::success('App Ticket saved successfully.');

        return redirect(route('appTickets.index'));
    }

    /**
     * Display the specified AppTicket.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $appTicket = $this->appTicketRepository->findWithoutFail($id);

        if (empty($appTicket)) {
            Flash::error('App Ticket not found');

            return redirect(route('appTickets.index'));
        }

        return view('app_tickets.show')->with('appTicket', $appTicket);
    }

    /**
     * Show the form for editing the specified AppTicket.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $appTicket = $this->appTicketRepository->findWithoutFail($id);

        if (empty($appTicket)) {
            Flash::error('App Ticket not found');

            return redirect(route('appTickets.index'));
        }

        return view('app_tickets.edit')->with('appTicket', $appTicket);
    }

    /**
     * Update the specified AppTicket in storage.
     *
     * @param  int              $id
     * @param UpdateAppTicketRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppTicketRequest $request)
    {
        $appTicket = $this->appTicketRepository->findWithoutFail($id);

        if (empty($appTicket)) {
            Flash::error('App Ticket not found');

            return redirect(route('appTickets.index'));
        }

        $appTicket = $this->appTicketRepository->update($request->all(), $id);

        Flash::success('App Ticket updated successfully.');

        return redirect(route('appTickets.index'));
    }

    /**
     * Remove the specified AppTicket from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $appTicket = $this->appTicketRepository->findWithoutFail($id);

        if (empty($appTicket)) {
            Flash::error('App Ticket not found');

            return redirect(route('appTickets.index'));
        }

        $this->appTicketRepository->delete($id);

        Flash::success('App Ticket deleted successfully.');

        return redirect(route('appTickets.index'));
    }


    /**
     * Send status to App
     *
     * @param  int $id
     *
     * @return Response
     */
    public function ticketStatus($ticket_id)
    {
        $data = $this->appTicketRepository->findWithoutFail($ticket_id);

        return response()->json(array("msg" => "Todo bien","data"=> $data));
    }
}
