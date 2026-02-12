<?php

namespace App\Http\Controllers;

use App\DataTables\AppTicketDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAppTicketRequest;
use App\Http\Requests\UpdateAppTicketRequest;
use App\Models\AppTicket;
use App\Models\PeopleUnlogged;
use App\Repositories\AppTicketRepository;
use App\Repositories\PeopleUnloggedRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Mail;
use Illuminate\Support\Facades\Log;

class AppTicketController extends AppBaseController
{
    /** @var  AppTicketRepository */
    private $appTicketRepository;
    private $peopleUnloggedRepository;


    public function __construct(AppTicketRepository $appTicketRepo, PeopleUnloggedRepository $peopleUnloggedRepo)
    {
        $this->appTicketRepository = $appTicketRepo;
        $this->peopleUnloggedRepository = $peopleUnloggedRepo;
    }

    public function openviewfalta(){
       // $reportes = AppTicket::get();
        //dd($reportes);
        return view('app_tickets.wordpressForm.faltaDeServicio');
    }
    public function faltaServicio(CreateAppTicketRequest $request){

        $input = $request->all();
        $people_unlogged = $this->peopleUnloggedRepository->create([
            "name" => $input["name"],
            //"name" => ($complaint_data["name"]) ? $complaint_data["name"] : null,
            "last_name_1" => $input["last_name_1"],
            "last_name_2" => $input["last_name_2"],
            "phone_number" => isset($input["phone_number"]) ? $input["phone_number"] : null,
            "email" => isset($input["email"]) ? $input["email"] : null,
        ]);
        $input["people_unlogged_id"] = $people_unlogged->id;
        $nombre_completo = $input['name'] .' '. $input['last_name_1']. ' ' .$input['last_name_2'];
        $appTicket = $this->appTicketRepository->create($input);
    
        try {
        $mail_data = ['tipo_de_reporte' => 'Falta de servicio', 'type' => 'Reporte', 'descripcion' => $input['description'], 'nombre_completo' => $nombre_completo, 'direccion'=>$input['address'] , 'numero_de_contrato' =>$input['contract'], 'medidor' => $input['meter'] , 'email'=>$input['email'] , 'telefono'=>$input['phone_number']];
        
        $to_name = $input['name'];
        $to_email = $input["email"];
        Mail::send('emails.falta_servicio', $mail_data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject('Reporte de falta de servicio');
            $message->from('contacto@japam.gob.mx','JAPAM');
        });
        }
        catch (exception $e) {
            //code to handle the exception
        }
        Flash::success('App Ticket saved successfully.');
       
        return redirect(route('falta.servicio'))->with(array(
            "message" => 'Reporte hecho correctamente'
        ));
        
        /*$reporte = new AppTicket();
        $reporte->
        return view('app_tickets.wordpressForm.faltaDeServicio', array(
            'data' => $reporte
        )); */
    }
    public function openviewfugas(){
        return view('app_tickets.wordpressForm.fugas');
    }
    public function guardarreportefuga(CreateAppTicketRequest $request){

        $input = $request->all();
        $people_unlogged = $this->peopleUnloggedRepository->create([
            "name" => $input["name"],
            //"name" => ($complaint_data["name"]) ? $complaint_data["name"] : null,
            "last_name_1" => $input["last_name_1"],
            "last_name_2" => $input["last_name_2"],
            "phone_number" => isset($input["phone_number"]) ? $input["phone_number"] : null,
            "email" => isset($input["email"]) ? $input["email"] : null,
        ]);
        $input["people_unlogged_id"] = $people_unlogged->id;
        $nombre_completo = $input['name'] .' '. $input['last_name_1']. ' ' .$input['last_name_2'];
       // Log::info("---------------------- fer >");
    //    Log::info($input);
        
        $appTicket = $this->appTicketRepository->create($input);

        Flash::success('App Ticket saved successfully.');
        
        try {
        $mail_data = ['tipo_de_reporte' => 'Fuga de agua', 'type' => 'Reporte', 'descripcion' => $input['description'], 'nombre_completo' => $nombre_completo, 'direccion'=>$input['address'] , 'numero_de_contrato' =>$input['contract'], 'medidor' => $input['meter'] , 'email'=>$input['email'] , 'telefono'=>$input['phone_number']];
        
        $to_name = $input['name'];
        $to_email = $input["email"];
        Mail::send('emails.falta_servicio', $mail_data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject('Reporte por fuga de agua');
            $message->from('contacto@japam.gob.mx','JAPAM');
        });
        }
        catch (exception $e) {
            //code to handle the exception
        }

        return redirect(route('reporte.fuga'))->with(array(
            "message" => 'Reporte hecho correctamente'
        ));
        
    }


    public function openviewtomasc(){
        return view('app_tickets.wordpressForm.tomasClandestinas');
    }
    public function guardarreportetoma(CreateAppTicketRequest $request){
        

        $input = $request->all();
        
       // Log::info("----------------------  >");
        //Log::info($input);

        $appTicket = $this->appTicketRepository->create($input);

        Flash::success('App Ticket saved successfully.');

        return redirect(route('toma.clandestina'))->with(array(
            "message" => 'Denuncia hecha correctamente'
        ));
       
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
}
