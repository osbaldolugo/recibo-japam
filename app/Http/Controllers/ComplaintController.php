<?php

namespace App\Http\Controllers;

use App\DataTables\ComplaintDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;
use App\Models\AppUser;
use App\Models\PeopleUnlogged;
use App\Repositories\AppUserRepository;
use App\Repositories\ComplaintRepository;
use App\Repositories\PeopleUnloggedRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Mail;
use Response;

class ComplaintController extends AppBaseController
{
    /** @var  ComplaintRepository */
    private $complainRepository;
    private $appUserRepository;
    private $peopleUnloggedRepository;


    public function __construct(ComplaintRepository $complainRepo, AppUserRepository $appUserRepo, PeopleUnloggedRepository $peopleUnloggedRepo)
    {
        $this->complainRepository = $complainRepo;
        $this->appUserRepository = $appUserRepo;
        $this->peopleUnloggedRepository = $peopleUnloggedRepo;
    }

    /**
     * Display a listing of the Complaint.
     *
     * @param ComplaintDataTable $complainDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ComplaintDataTable $complainDataTable)
    {

        $type = "queja";
        return $complainDataTable->typeComplaint($type)->render('complaints.index', compact('type'));
    }


    /**
     * Display a listing of the Complaint.
     *
     * @param ComplaintDataTable $complainDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function indexDate(ComplaintDataTable $complainDataTable)
    {
        $type = "cita";
        return $complainDataTable->typeComplaint($type)->render('complaints.index', compact('type'));
    }


    /**
     * Render view to create complaint
     *
     * @return Response
     */
    public function complainCreate()
    {
        return view('user_panel.complain-create');
    }

    /**
     * Render view to create schedule request
     *
     *
     * @return Response
     */
    public function scheduleRequest()
    {
        return view('user_panel.schedule-request');
    }


    /**
     * Show the form for creating a new Complaint.
     *
     * @return Response
     */
    public function create()
    {
        return view('complaints.create');
    }

    /**
     * Store a newly created Complaint in storage.
     *
     * @param CreateComplaintRequest $request
     *
     * @return Response
     */
    public function store(CreateComplaintRequest $request)
    {
        $complaint_data = $request->all();

        if (!isset($complaint_data["app_user_id"])) {
            $people_unlogged = $this->peopleUnloggedRepository->create([
                "name" => $complaint_data["name"],
                "last_name_1" => $complaint_data["last_name_1"],
                "last_name_2" => $complaint_data["last_name_2"],
                "phone_number" => isset($complaint_data["phone_number"]) ? $complaint_data["phone_number"] : null,
                "email" => isset($complaint_data["email"]) ? $complaint_data["email"] : null,
            ]);
            $complaint_data["people_unlogged_id"] = $people_unlogged->id;
        }
        $complaint = $this->complainRepository->create($complaint_data);

        return response()->json(array("success" => 1, "content" => "datos registrados correctamente", "title" => "Enviado"));
    }

    /**
     * Display the specified Complaint.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $complain = $this->complainRepository->findWithoutFail($id);

        if (empty($complain)) {
            Flash::error('Complaint not found');

            return redirect(route('complaints.index'));
        }

        return view('complaints.show')->with('complain', $complain);
    }

    /**
     * Show the form for editing the specified Complaint.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $complain = $this->complainRepository->findWithoutFail($id);

        if (empty($complain)) {
            Flash::error('Complaint not found');

            return redirect(route('complaints.index'));
        }

        return view('complaints.edit')->with('complain', $complain);
    }

    /**
     * Update the specified Complaint in storage.
     *
     * @param  int $id
     * @param UpdateComplaintRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateComplaintRequest $request)
    {
        $complain = $this->complainRepository->findWithoutFail($id);

        if (empty($complain)) {
            Flash::error('Complaint not found');

            return redirect(route('complaints.index'));
        }

        $complain = $this->complainRepository->update($request->all(), $id);

        Flash::success('Complaint updated successfully.');

        return redirect(route('complaints.index'));
    }

    /**
     * Remove the specified Complaint from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $complain = $this->complainRepository->findWithoutFail($id);

        if (empty($complain)) {
            Flash::error('Complaint not found');

            return redirect(route('complaints.index'));
        }

        $this->complainRepository->delete($id);

        Flash::success('Complaint deleted successfully.');

        return redirect(route('complaints.index'));
    }


    public function sendMailComplaintReport($data)
    {
        $type_string = '';
        switch ($data['type']) {
            case 'Queja':
                $type_string = 'una Queja';
                break;
            case 'Cita':
                $type_string = 'una Cita';
                break;
        }
        $mailData = [
            'name' => is_null($data['name']) ? 'Anonimo' : $data['name'] . ' ' . $data['lastnames'],
            'type_string' => $type_string,
            'type' => $data['type'],
            'phone_number' => is_null($data['name']) ? 'Anonimo' : $data['phoneNumber'],
            'complaint' => $data['description']
        ];
        Mail::send('emails.create_complaint', $mailData, function ($messages) use ($data) {
            $messages->to('atem_82025@hotmail.com')
                ->cc(is_null($data['email']) ? 'anonimo@mail.com' : $data['email'])
                ->bcc('depapp@ideasysolucionestecnologicas.com')
                ->subject('JAPAM');
        });
    }
}
