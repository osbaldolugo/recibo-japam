<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use App\Models\Complaint;
use DB;
use Mail;
use Auth;
use Storage;
use DateTime;
use Carbon\Carbon;
use App\Events\Push;
use App\Models\Agent;
use App\Models\Comment;
use App\Models\AppUser;
use App\Models\AppTicket;
use App\Libraries\ApiJapam;
use App\Models\ReceiptUser;
use Illuminate\Http\Request;
use App\Models\PeopleUnlogged;
use App\Http\Controllers\AppBaseController;

class TicketController extends AppBaseController
{

    public function __construct()
    {
        if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
            $this->middleware('auth:apiweb');
        }
    }

    public function index()
    {
        $people = Ticket::query()
                ->with('priority')
                ->with('appTicket')
                ->with('appTicket.appUser')
                ->with('appTicket.peopleUnlogged')
                ->with('agent')
                ->with('user')
                ->with('category')
                ->with('incident')
                ->with('mergeSon')
                ->with('mergeFather')
                ->with('lastComment')
                ->withCount('comments')
                ->with('suburb')->paginate(15);

        return response()->json(array($people),200);

    }

    public function getComments($idTicket){

        $ticket_merge = Ticket::where('id', $idTicket)->with('mergeFather.mergeSon')->get();
        $ticket_merge = $this->recursiveMerged([], $ticket_merge[0]->mergeFather);
        if ($ticket_merge == null) {
            $comments = Comment::with('user')->where('ticket_id', $idTicket)->with("notificationUsers")->orderBy('created_at')->get()->toArray();
        } else {
            $comments = Comment::with('user')->whereIn('ticket_id', $ticket_merge['tickets_id'])->orWhere('ticket_id', $idTicket)->with("notificationUsers")->orderBy('created_at')->get()->toArray();
        }
        return response()->json(['comments' => $comments, 'image_default' => url('img/man.png'), 'image' => \URL::to('../storage/app/public/user/')], 200);

    }

    /**
     * Recursive method to read de sons ticket merged
     *
     * @param array $ticket_father
     * @param Collection $ticket
     *
     * @return array $ticket
     */
    public function recursiveMerged($ticket_father, $ticket)
    {
        if ($ticket == null) {
            return null;
        } else {
            foreach ($ticket as $ticket_son) {
                $ticket_father['tickets_id'][] = $ticket_son->mergeSon->id;
                $ticket = $ticket_son->mergeSon;
                $ticket->user = $ticket_son->mergeSon->user()->get()[0];
                $ticket->incident = $ticket_son->mergeSon->incident()->get()[0];
                $ticket_father['son'][] = $ticket;
//                $ticket_father['son'][]['user'] = $ticket_son->mergeSon->user()->get()->toArray();
                //dd($ticket_son->mergeSon->mergeFather()->with('mergeSon')->get());
                $ticket_father = $this->recursiveMerged($ticket_father, $ticket_son->mergeSon->mergeFather()->with('mergeSon')->get());
            }
            return $ticket_father;
        }

    }


    public function store(Request $request)
    {
        $data = $request->all();
        //dd($data);
        /*
        $address = 'Constituyentes, Ext. 10 / Int. 15, Cuarto Centenario, San Juan del Río, Qro.';
        $listAddress = explode(",", $address);
        $listNum = explode("/", $listAddress[1]);
        dd($listAddress, $listNum);
        */
        //dd($data["isAnonymous"]);
        try {
            DB::beginTransaction();
            $people = null;
            if (!Auth::check() && !$data['isAnonymous']) {
                $lastnames = explode(" ", $data['lastnames']);

                $requestPeople = [
                    'name' => $data['name'],
                    'last_name_1' => isset($lastnames[0]) ? $lastnames[0] : null,
                    'last_name_2' => isset($lastnames[1]) ? $lastnames[1] : null,
                    'phone_number' => $data['phoneNumber'],
                    'email' => $data['email']
                ];

                $people = PeopleUnlogged::updateOrCreate($requestPeople, $requestPeople);
            }

            $appTicket = AppTicket::create([
                'app_user_id' => $data['isAnonymous'] ? null : Auth::check() ? Auth::user()->id : null,
                'people_unlogged_id' => $people ? $people->id : null,
                'meter' => isset($data['meter'])?$data['meter']:null,
                'contract' => isset($data['contract'])?$data['contract']:null,
                'address' => $data['address'],
                'description' => $data['description'],
                'url_image' => null,
                'latitude' => $data['lat'],
                'longitude' => $data['lng'],
                'report_type' => isset($data['reportType'])?$data['reportType']:null,
                'type' => $data['type'],
                'origen' => $data['origen']
            ]);

            if (isset($data['image'])) {
                $dataImg = base64_decode($data['image']);
                $filename = $appTicket->id . '.jpg';
                $routeImagen = 'japam/app_ticket/' . $filename;
                $appTicket->url_image = $filename;
                Storage::put($routeImagen, $dataImg);

                $appTicket->save();
            }

            $comment_create = [
                'content' => 'Se ha generado un nuevo pre-ticket desde la App',
                'html' => 'Se ha generado un nuevo pre-ticket desde la App ' . $appTicket->id,
                'html_notification' => '<li class="media">
                        <a href="javascript:;">
                            <div class="media-left"><i class="fa fa-phone-square bg-gradient-green-dark"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading"> Nuevo pre-ticket ' . $appTicket->id . '</h6>
                                <p>Se ha actualizado el responsable del tiquet</p>
                            </div>
                        </a>
                    </li>',
                'icon' => 'fa-phone-square',
                'user_id' => null
            ];

            $users = Agent::whereHas('categories', function ($query) {
                $query->where('category_id', 6);
            })->get();


            $comment = Comment::newComment(null, $comment_create, $users);
            foreach ($users as $u => $user) {
                event(new Push($comment_create, $appTicket, $user));
            }
            DB::commit();

            $this->sendMailComplaintReport($data);

            $msg = $appTicket->type == 'Reporte' ? 'Reporte registrado correctamente.' : 'Denuncia registrada correctamente.';
            return response()->json(['msg' => $msg]);
        } catch (Exeption $ex) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrio un error al registrar la incidencia.'], 422);
        }
    }

    public function generateComplaint(Request $request)
    {
        $data = $request->all();
        $requestType = $data['type'] == 'queja' ? 'Queja' : 'Cita';

        try {
            DB::beginTransaction();
            $people = null;
            if (!Auth::check() && !$data['isAnonymous']) {
                $lastnames = explode(" ", $data['lastnames']);

                $values = [
                    'name' => $data['name'],
                    'last_name_1' => isset($lastnames[0]) ? $lastnames[0] : null,
                    'last_name_2' => isset($lastnames[1]) ? $lastnames[1] : null,
                    'phone_number' => $data['phoneNumber'],
                    'email' => $data['email']
                ];

                $people = PeopleUnlogged::updateOrCreate($values, $values);
            }

             Complaint::create([
                'app_user_id' => $data['isAnonymous'] ? null : Auth::check() ? Auth::user()->id : null,
                'people_unlogged_id' => $people ? $people->id : null,
                'description' => $data['description'],
                'type' => $data['type'],
                'recibo' => $data['numbereceipt'],
                'contrato' => $data['numbercontract'],
                'origen' => $data['origen']
            ]);

            DB::commit();

            $this->sendMailsAppointments($data);

            return response()->json(['msg' => $requestType.' generada correctamente.']);
        } catch (Exeption $ex) {
            DB::rollback();
            return response()->json(['error' => 'Ocurrio un error al generar la '.$requestType.'.'], 422);
        }
    }

    public function sendMailComplaintReport($data)
    {
        $type_string='';
        switch ($data['type']) {
            case 'Reporte':
                $type_string = 'un Reporte';
                break;
            case 'Denuncia':
                $type_string = 'una Denuncía';
                break;
        }
        $mailData = [
            'name' => is_null($data['name']) ? 'Anonimo' : $data['name'] .' '. $data['lastnames'],
            'type_string' => $type_string,
            'type' => $data['type'],
            'address' => $data['address'],
            'phone_number' => is_null($data['name']) ? 'Anonimo' : $data['phoneNumber'],
            'complaint'=>$data['description'],
            'contract' =>isset($data['contract'])?$data['contract']:null,
            'meter' =>isset($data['meter'])?$data['meter']:null,
            'report_type' =>isset($data['reportType'])?$data['reportType']:null,
        ];
        Mail::send('emails.create_complaint', $mailData, function ($messages) use ($data) {
            $messages->to('contacto@japam.gob.mx')
                ->cc(is_null($data['email']) ? 'anonimo@mail.com':$data['email'])
                ->bcc('depapp@ideasysolucionestecnologicas.com')
                ->subject($data['name'] . ' [C:' . $data['contract'] . ' - M:' . $data['meter'] . '] Japam Movil');
        });
    }

    public function sendMailsAppointments($data)
    {
        $type = $data['type'];

        $mailData = [
            'name' => is_null($data['name']) ? 'Anonimo' : $data['name'] .' '. $data['lastnames'],
            'type' => $data['type'] == 'queja' ? 'Descripción de Queja' : 'Descripción de Solicitud',
            'title' => $data['type'],
            'phone_number' => is_null($data['name']) ? 'Anonimo' : $data['phoneNumber'],
            'description'=>$data['description']
        ];

        Mail::send('emails.generate_complaint', $mailData, function ($messages) use ($data) {
            $messages->to('contacto@japam.gob.mx')
                //->cc(is_null($data['email']) ? 'anonimo@mail.com':$data['email'])
                ->bcc('depapp@ideasysolucionestecnologicas.com')
                ->subject('JAPAM');
        });

        if ($type == 'cita')
            Mail::send('emails.confirmation_appoinment', $mailData, function ($messages) use ($data) {
                $messages->to($data['email'])
                    //->cc(is_null($data['email']) ? 'anonimo@mail.com':$data['email'])
                    ->bcc('depapp@ideasysolucionestecnologicas.com')
                    ->subject('JAPAM');
            });
    }
}
