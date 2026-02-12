<?php

namespace App\Http\Controllers;

use App\Events\Comments;
use App\Libraries\ApiJapam;
use App\Models\AppTicket;
use App\Models\Comment;
use App\Events\Push;
use App\Models\Incidents;
use App\Models\PeopleUnlogged;
use App\Models\Priority;
use App\Models\Receipt;
use App\Models\Status;
use App\Models\Suburb;
use App\Models\TicketitMerge;
use App\Models\TicketitNotification;
use App\Repositories\AppTicketRepository;
use App\User;
use Cache;
use Carbon\Carbon;
use DB;
use function foo\func;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Auth;
use App\DataTables\TicketDataTables;
use App\Http\Helpers\LaravelVersion;
use App\Models\Agent;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Ticket;
use Jenssegers\Date\Date;
use Yajra\Datatables\Datatables;
use Yajra\Datatables\Engines\EloquentEngine;

class TicketsController extends Controller
{
    protected $tickets;
    protected $agent;
    protected $appTicketRepository;

    public function __construct(Ticket $tickets, Agent $agent, AppTicket $appTicketRepo)
    {
        //$this->middleware('ResAccess', ['only' => ['show']]);
        $this->middleware('IsAgent', ['only' => ['edit', 'update']]);
        $this->middleware('IsAdmin', ['only' => ['destroy']]);

        $this->tickets = $tickets;
        $this->agent = $agent;
        $this->appTicketRepository = $appTicketRepo;

    }

    /**
     * Display a listing of active tickets related to user.
     *
     * @param TicketDataTables $ticketDataTables
     * @return JsonResponse|\Illuminate\View\View
     */
    public function index(TicketDataTables $ticketDataTables)
    {
        $isAdmin = Agent::isAdmin();
        //$isAgent = Agent::isAgent(Auth::user()->id);
        $categories = Category::all()->pluck('name', 'id');
        $users = Agent::all()->pluck('name', 'id');
        $permits = Ticket::isGlobalView(); //
        \View::share(['isAdmin' => $isAdmin, 'permits' => $permits, 'department' => $categories, 'users' => $users]);
        return $ticketDataTables->render('kordy.index');
    }

    /**
     * Returns priorities, categories and statuses lists in this order
     * Decouple it with list().
     *
     * @return array
     */
    protected function PCS()
    {
        $priorities = Cache::remember('ticketit::priorities', 60, function () {
            return Priority::all();
        });
        $categories = Cache::remember('ticketit::categories', 60, function () {
            return Category::all();
        });
        $statuses = Cache::remember('ticketit::statuses', 60, function () {
            return Status::all();
        });
        $incidents = Cache::remember('ticketit::incidents', 60, function () {
            return Incidents::all();
        });
        $suburbs = Cache::remember('ticketit::suburbs', 60, function () {
            return Suburb::all();
        });

        if (LaravelVersion::min('5.3.0')) {
            return [$priorities->pluck('name', 'id'), $categories->pluck('name', 'id'), $statuses->pluck('name', 'id'), $incidents->pluck('name', 'id'), $suburbs->pluck('suburb', 'id')];
        } else {
            return [$priorities->lists('name', 'id'), $categories->lists('name', 'id'), $statuses->lists('name', 'id'), $incidents->lists('name', 'id'), $suburbs->lists('suburb', 'id')];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //Cache::forget('ticketit::suburbs');
        //dd('HOLO');
        list($priorities, $categories, $statuses, $incidents, $suburbs) = $this->PCS();

        return view('kordy.tickets.create', compact('priorities', 'categories', 'statuses', 'incidents', 'suburbs'));
    }

    /**
     * Send AppTicket to Ticket create
     *
     * @param  int $appTicket_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createTicket($appTicket_id)
    {
        $appTicket = $this->appTicketRepository->with("peopleUnlogged")->with("appUser.people")->find($appTicket_id);

        $address = explode(",", $appTicket["address"]);
        $noAddress = explode("/", $address[1]);

        $appTicket["street"] = isset($address[0]) ? $address[0] : "";
        $appTicket["outside_number"] = isset($noAddress[0]) ? $noAddress[0] : "";
        $appTicket["inside_number"] = isset($noAddress[1]) ? $noAddress[1] : "";
        $appTicket["suburb"] = isset($address[2]) ? $address[2] : "";
        $appTicket["locality"] = isset($address[3]) ? $address[3] : "";
        $appTicket["state"] = isset($address[4]) ? $address[4] : "";

        //dd($appTicket);
        list($priorities, $categories, $statuses, $incidents, $suburbs) = $this->PCS();

        $similar_tickets = $this->listSimilarTickets(null, $appTicket->latitude, $appTicket->longitude);
        //dd($similar_tickets->isEmpty());
        return view('kordy.tickets.create', compact('priorities', 'categories', 'statuses', 'incidents', 'suburbs', 'appTicket', 'similar_tickets'));

    }

    /**
     * Store a newly created ticket and auto assign an agent for it.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        //La función unicamente sirve para cuando se van a llenar todos los campos.. es necesario actualizarla para adaptarse a las validaciones
        try {
            DB::beginTransaction();
            /*$receiptRequest = $request->input('receipt');
            $receiptFind = Receipt::where('contract', $receiptRequest['contract'])->where('barcode', $receiptRequest['barcode'])->get()->first(); //Buscamos si el recibo ya se encunetra registrado;
            if (empty($receiptFind))
                $receiptCreate = Receipt::create($receiptRequest);
            else
                $receiptCreate = $receiptFind;*/
            //Information of the person who called
            $peopleUnloggedRequest = $request->input('people_unlogged');
            //Information of pre-ticket
            $appTicketRequest = $request->input('app_ticket');
            $ticketRequest = $request->input('ticketit');
            //We verify if it is generated from a pre-ticket
            if (isset($peopleUnloggedRequest)) { //Is not generated from a pre-ticket
                if ($request->input('isDirectOrder')) {
                    $appTicketRequest['description'] = 'Realizado para generar una Orden de Trabajo';
                    $appTicketRequest['report_type'] = 'Orden Directa';
                } else {
                    if (empty($ticketRequest['id']))
                        $appTicketRequest['description'] = 'Realizado a partir de una llamada teléfonica a Call Center';
                    else
                        $appTicketRequest['description'] = clean($ticketRequest['html'], ['HTML.Allowed' => '']);
                    $appTicketRequest['report_type'] = 'Llamada Telefónica';
                }
                /* It is verified that the information of the person does not come empty if it is not required
                 * From the view where the reason for the call is selected, it is specified if this information is required. Here we are only determining if the information is being received to take one action or another.
                 */
                if (empty($peopleUnloggedRequest['name'])) {// Is Anonimous
                    $appTicketRequest['type'] = 'Reporte';
                    $appTicketCreate = AppTicket::create($appTicketRequest);
                } else {// Is not Anonimous
                    $people = PeopleUnlogged::create($peopleUnloggedRequest);
                    //Add the app ticket information
                    $appTicketRequest['type'] = 'Denuncia';
                    $appTicketCreate = $people->appTickets()->create($appTicketRequest);
                }
            } else { //Is generated from a pre-ticket
                //we look for the pre-ticket information
                $appTicketCreate = AppTicket::where('id', $appTicketRequest["id"])->get();
            }
            //Add the ticket in this way, because you need to get the folio of it and purify the html of the reason for calling
            if (empty($ticketRequest['id'])) {
                $ticketCreate = new Ticket();
                $ticketCreate->nextFolio();
                $ticketCreate->user_id = Auth::user()->id;
                //$ticketCreate->status = $ticketRequest['status'];
                $ticketCreate->priority_id = $ticketRequest['priority_id'];
                $ticketCreate->category_id = $ticketRequest['category_id'];
                $ticketCreate->incidents_id = $ticketRequest['incidents_id'];
                $ticketCreate->street = $ticketRequest['street'];
                $ticketCreate->outside_number = $ticketRequest['outside_number'];
                $ticketCreate->inside_number = $ticketRequest['inside_number'];
                $ticketCreate->cp = $ticketRequest['cp'];
                $ticketCreate->suburb_id = $ticketRequest['suburb_id'];
                $ticketCreate->latitude = $ticketRequest['latitude'];
                $ticketCreate->longitude = $ticketRequest['longitude'];
                $ticketCreate->setPurifiedContent($ticketRequest['html']);
                $ticketCreate->autoSelectAgent();
                $ticketCreate->save();

                $comment_create = [
                    'content' => 'Ha generado el Ticket con el Folio: ' . $ticketCreate->folio,
                    'html' => 'Ha generado el Ticket con el Folio: <h2>' . $ticketCreate->folio . '</h2>',
                    'html_notification' => '<li class="media">
                        <a href="' . route('tickets.show', $ticketCreate->id) . '">
                            <div class="media-left"><i class="fa fa-plus media-object bg-success"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading"> Tiquet generado FOLIO: <u>' . $ticketCreate->folio . '</u></h6>
                                <p>' . Auth::user()->name . ' ha generado un nuevo Ticket</p>
                                <div class="text-muted f-s-11">' . $ticketCreate->created_at->format('d/F/Y g:i A') . '</div>
                            </div>
                        </a>
                    </li>',
                    'icon' => 'fa fa-check-square',
                    'user_id' => Auth::user()->id
                ];
                $content = 'Se ha agregado el nuevo ticket al sistema';
            } else {
                $content = 'Se ha enlazado la información a otro Ticket';
                $ticketCreate = Ticket::find($ticketRequest['id']);
                $comment_create = [
                    'content' => 'Se ha enlazado información al Ticket con el Folio: ' . $ticketCreate->folio,
                    'html' => 'Se ha enlazado información al Ticket con el Folio: <h2>' . $ticketCreate->folio . '</h2>',
                    'html_notification' => '<li class="media">
                        <a href="' . route('tickets.show', $ticketCreate->id) . '">
                            <div class="media-left"><i class="fa fa-exchange media-object bg-success"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading"> Tiquet enlazado al FOLIO: <u>' . $ticketCreate->folio . '</u></h6>
                                <p>' . Auth::user()->name . ' ha enlazado un nuevo Ticket</p>
                                <div class="text-muted f-s-11">' . $ticketCreate->created_at->format('d/F/Y g:i A') . '</div>
                            </div>
                        </a>
                    </li>',
                    'icon' => 'fa fa-exchange',
                    'user_id' => Auth::user()->id
                ];
            }
            $ticketCreate->appTicket()->attach($appTicketCreate);

            $user = Agent::where('id', Auth::user()->id);
            $users = Agent::whereHas('categories', function ($query) use ($ticketRequest) {
                $query->where('category_id', $ticketRequest['category_id']);
            })->union($user)->get();
            $ticketCreate->userSubs()->attach($users);
            $comment = Comment::newComment($ticketCreate, $comment_create, $users);

            if ($comment == null) {
                DB::rollBack();
                return response()->json(['message' => 'Lo sentimos pero no fue posible guardar el ticket'], 500);
            } else {
                foreach ($users as $u => $user) {
                    event(new Push($comment_create, $ticketCreate, $user));
                }
                DB::commit();
                if ($request->input('isDirectOrder'))
                    $load = route('pmoWorkTables.orderWorkCreate', $ticketCreate->id);
                else
                    $load = route('tickets.create');
                return response()->json(['content' => $content, 'title' => 'FOLIO: ' . $ticketCreate->folio, 'load' => $load], 200);
            }

        } catch (QueryException $e) {
            DB::rollBack();
            \Log::error('Code: ' . $e->getCode() . ' Error: ' . $e->getMessage());
            return response()->json(['message' => 'Code: ' . $e->getCode() . '<br/>' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($id)
    {
        //We obtain the information corresponding to the Ticket
        $ticket = Ticket::where('id', $id)->with('appTicket.peopleUnlogged.receipt')->with('appTicket.appUser.people')->with('appTicket.appUser.userReceipt')
            ->with('suburb')->with('priority')->with('agent')->with('user')->with('category')->with('incident')->with('mergeSon.mergeFather')->with('userSubsI')->get()->first();
        if (empty($ticket)) { //In case we do not find the Ticket
            \Flash::error('Lo sentimos, pero no encontramos el ticket que esta intentando ver.');
            return redirect(route('tickets.index'));
        }
        //In case we want to reassign the responsibility of the ticket
        $all_categories = Category::has('agents')->get();
        //In case you want to assign me the responsibility of the ticket
        $myCategories = Category::whereHas('agents', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->get();

        //We verify if a merge has been made for the Ticket
        $ticket_merge = Ticket::where('id', $id)->with('mergeFather.mergeSon')->get();
        //We obtain the IDs of the children Tickets
        $ticket_merge = $this->recursiveMerged([], $ticket_merge[0]->mergeFather);
        //We check if the Ticket has children to get their comments
        $tickets_merged = empty($ticket_merge) ? null : $ticket_merge['son'];
        if ($ticket_merge == null) {
            $comments = Comment::with('user')->where('ticket_id', $id)->orderByDesc('created_at')->get();
        } else {
            $comments = Comment::with('user')->whereIn('ticket_id', $ticket_merge['tickets_id'])->orWhere('ticket_id', $id)->orderByDesc('created_at')->get();
        }
        //We update the notification as view
        TicketitNotification::where('user_receipt_id', Auth::user()->id)->whereIn('comment_id', DB::table('ticketit_comments')->select('id')->where('ticket_id', $id))->update(['view' => 1]);
        if ($ticket->mergeSon == null) {
            $similar_tickets = $this->listSimilarTickets($id, $ticket->latitude, $ticket->longitude);
            return view('kordy.tickets.show', compact('ticket', 'all_categories', 'myCategories', 'similar_tickets', 'tickets_merged', 'comments'));
        } else {
            return view('kordy.tickets.show', compact('ticket', 'tickets_merged', 'comments'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'subject' => 'required|min:3',
            'content' => 'required|min:6',
            'priority_id' => 'required|exists:ticketit_priorities,id',
            'category_id' => 'required|exists:ticketit_categories,id',
            'status_id' => 'required|exists:ticketit_statuses,id',
            'agent_id' => 'required',
        ]);

        $ticket = $this->tickets->findOrFail($id);

        $ticket->subject = $request->subject;

        $ticket->setPurifiedContent($request->get('content'));

        $ticket->status_id = $request->status_id;
        $ticket->category_id = $request->category_id;
        $ticket->priority_id = $request->priority_id;

        if ($request->input('agent_id') == 'auto') {
            $ticket->autoSelectAgent();
        } else {
            $ticket->agent_id = $request->input('agent_id');
        }

        $ticket->save();

        session()->flash('status', trans('lang.the-ticket-has-been-modified'));

        return redirect()->route(Setting::grab('main_route') . '.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $ticket = $this->tickets->findOrFail($id);
        $subject = $ticket->subject;
        $ticket->delete();

        session()->flash('status', trans('lang.the-ticket-has-been-deleted', ['name' => $subject]));

        return redirect()->route(Setting::grab('main_route') . '.index');
    }

    /**
     * Reasign the ticket to new USER
     * @param int $id , int $agent_id
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function reAsing($id, $agent_id, $category_id)
    {
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($id);
            $ticket->agent_id = $agent_id;
            $ticket->category_id = $category_id;
            $ticket->save();
            $agente = $ticket->agent()->get()->first();
            //dd($agente->name);
            $comment_create = [
                'content' => 'Se ha reasignado la responsabilidad del Ticket a ' . $agente->name . 'del equipo de ' . $ticket->category->name,
                'html' => 'Se ha reasignado la responsabilidad del Ticket a <strong>' . $agente->name . '</strong> del equipo de <strong>' . $ticket->category->name . '</strong>',
                'html_notification' => '<li class="media">
                    <a href="' . route('tickets.show', $id) . '">
                        <div class="media-left"><i class="fa fa-random media-object bg-grey"></i></div>
                        <div class="media-body">
                            <h6 class="media-heading"> Se ha actualizado el responsable del Ticket</h6>
                            <p>' . Auth::user()->name . ' ha actualizado el responsable del Ticket</p>
                            <div class="text-muted f-s-11">' . $ticket->created_at->format('d/F/Y g:i A') . '</div>
                        </div>
                    </a>
                </li>',
                'icon' => 'fa fa-random',
                'user_id' => Auth::user()->id
            ];
            $user = Agent::where('id', Auth::user()->id)->orWhere('id', $ticket->user_id);
            $last_users = Agent::whereHas('userSubs', function ($query) use ($id) {
                $query->where('ticket_id', $id);
            });
            $users = Agent::whereHas('categories', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            })->union($user);
            $ticket->userSubs()->detach($last_users->get());
            $ticket->userSubs()->attach($users->get());
            $comment = Comment::newComment($ticket, $comment_create, $users->union($last_users)->get());
            if ($comment == null) {
                DB::rollBack();
                return response()->json(['message' => 'Lo sentimos pero no fue posible cambiar el usuario asignado'], 500);
            } else {
                foreach ($users->union($last_users)->get() as $u => $user) {
                    event(new Push($comment_create, $ticket, $user));
                }
                $newComment = Comment::where('id', $comment->id)->with('user')->get()->toArray();
                event(new Comments($newComment[0]));
                DB::commit();
                return response()->json(['title' => 'Cambio de asignación del Ticket', 'msg' => 'Se ha realizado el cambio del responsable del Ticket a ' . $agente->name], 200);
            }
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Code: ' . $e->getCode() . '<br/>' . $e->getMessage()], 500);
        }
    }

    /**
     * Merge tickets
     * @param int $id
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function mergeTicket(Request $request, $ticket_id)
    {
        try {
            $ticket_son_request = $request->input('ticket_son');
            //dd($ticket_son);
            $ticket_folio = [];
            DB::beginTransaction();
            foreach ($ticket_son_request as $item => $son) {
                TicketitMerge::create([
                    'ticket_son' => $son,
                    'ticket_father' => $ticket_id,
                    'user_id' => Auth::user()->id
                ]);
                $ticket_folio[] = 'N° ' . Ticket::select('folio')->where('id', $son)->get()->first()->folio;
            }
            //dd($array_merge_create);
            $ticket = Ticket::find($ticket_id);
            $ticket->updated_at = Carbon::now();
            $ticket->save();
            $comment_create = [
                'content' => 'Se han unido los Tickets ' . implode(", ", $ticket_folio),
                'html' => '<p>Se realizo un merge para absorver los Tickets <strong>' . implode(", ", $ticket_folio) . '</strong></p>',
                'html_notification' => '<li class="media">
                    <a href="' . route('tickets.show', $ticket_id) . '">
                        <div class="media-left"><i class="fa fa-code-fork media-object bg-inverse"></i></div>
                        <div class="media-body">
                            <h6 class="media-heading"> Merge generado </h6>
                            <p>Se realizo un merge para absorver los Tickets <strong>' . implode(", ", $ticket_folio) . '<i class="fa fa-angle-double-up"></i></strong></p>
                            <div class="text-muted f-s-11">' . $ticket->updated_at->format('d/F/Y g:i A') . '</div>
                        </div>
                    </a>
                </li>',
                'icon' => 'fa fa-code-fork',
                'user_id' => Auth::user()->id
            ];
            $ticket_agent_id = Ticket::select('agent_id')->whereIn('id', $ticket_son_request)->get()->toArray();
            $user = Agent::where('id', Auth::user()->id)->orWhere('id', $ticket->user_id);
            $last_users = Agent::whereHas('userSubs', function ($query) use ($ticket_id) {
                $query->where('ticket_id', $ticket_id);
            });
            $users = Agent::whereHas('userSubs', function ($query) use ($ticket_agent_id) {
                $query->whereIn('ticket_id', $ticket_agent_id);
            })->union($user);
            //$ticket->userSubs()->detach($last_users->get());
            //$ticket->userSubs()->attach($users->get());
            $comment = Comment::newComment($ticket, $comment_create, $users->union($last_users)->get());
            if ($comment == null) {
                DB::rollBack();
                return response()->json(['message' => 'Lo sentimos pero no fue posible unir los Tickets'], 500);
            } else {
                foreach ($users->union($last_users)->get() as $u => $user) {
                    event(new Push($comment_create, $ticket, $user));
                }
                //dd($ticket);
                $newComment = Comment::where('id', $comment->id)->with('user')->get()->toArray();
                event(new Comments($newComment[0]));
                DB::commit();
                return response()->json(['title' => 'Unión exitosa', 'msg' => 'La información de los Tickets ha sido unida con la de este Ticket', 'refresh' => true]);
            }
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Code: ' . $e->getCode() . '<br/>' . $e->getMessage()], 500);
        }
    }

    /**
     * Revert merge ticket
     * @param int $ticket_father
     * @param int $ticket_son
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function mergeTicketRevert($ticket_father, $ticket_son)
    {
        try {
            DB::beginTransaction();
            $delete = TicketitMerge::where('ticket_son', $ticket_son)->where('ticket_father', $ticket_father)->delete();
            if ($delete) {
                $ticket = Ticket::find($ticket_son);
                $ticket->updated_at = Carbon::now();
                $ticket->save();
                $ticket_father = Ticket::find($ticket_father);
                $comment_create = [
                    'content' => 'Se ha revertido un merge Tiquet N°' . $ticket_father->folio,
                    'html' => 'Se ha revertido un merge <strong>Tiquet N°' . $ticket_father->folio . ' <i class="fa fa-angle-double-down"></i></strong>',
                    'html_notification' => '<li class="media">
                        <a href="' . route('tickets.show', $ticket_son) . '">
                            <div class="media-left"><i class="fa fa-chain-broken media-object bg-warning"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading"> Merge revertido</h6>
                                <p>Se ha revertido un merge <strong>Tiquet N°' . $ticket_father->folio . ' <i class="fa fa-angle-double-down"></i></strong></p>
                                <div class="text-muted f-s-11">' . Carbon::now()->format('d/F/Y g:i A') . '</div>
                            </div>
                        </a>
                    </li>',
                    'icon' => 'fa fa-chain-broken',
                    'user_id' => Auth::user()->id
                ];
                $users_son = Agent::whereHas('userSubs', function ($query) use ($ticket_son) {
                    $query->where('ticket_id', $ticket_son);
                });
                $users_father = Agent::whereHas('userSubs', function ($query) use ($ticket_father) {
                    $query->where('ticket_id', $ticket_father);
                });
                $users = Agent::where('id', Auth::user()->id)->orWhere('id', $ticket->user_id)->union($users_son)->union($users_father);

                $comment = Comment::newComment($ticket, $comment_create, $users->get());
                if ($comment == null) {
                    DB::rollBack();
                    return response()->json(['message' => 'Lo sentimos pero no fue posible separar los Tickets'], 500);
                } else {
                    foreach ($users as $u => $user) {
                        event(new Push($comment_create, $ticket, $user));
                    }
                    $newComment = Comment::where('id', $comment->id)->with('user')->get()->toArray();
                    event(new Comments($newComment[0]));
                    DB::commit();
                    return response()->json(['title' => 'Separación exitosa', 'msg' => 'La información de los Tickets se ha separado', 'refresh' => true]);
                }
            } else {
                DB::rollBack();
                return response()->json(['message' => 'Lo sentimos pero no fue posible separar los Tickets'], 500);
            }
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Code: ' . $e->getCode() . '<br/>' . $e->getMessage()], 500);
        }
    }

    /**
     * Send a reminder to the person responsible for the Ticket
     *
     * @param $ticket_id
     * @return JsonResponse
     */
    public function sendReminder($ticket_id) {
        $ticket = Ticket::find($ticket_id);
        $user = Agent::where('id', $ticket->agent_id)->get()[0];
        $date = new Date(Carbon::now());

        $comment_create = [
            'content' => 'Te ha llegado un recordatorio',
            'html' => '<p>' . Auth::user()->name . ' hace un recordatorio al responsable del Ticket con el folio <strong>' . $ticket->folio . '</strong></p>',
            'html_notification' => '<li class="media">
                <a href="' . route('tickets.show', $ticket_id) . '">
                    <div class="media-left"><i class="fa fa-bullhorn media-object bg-orange"></i></div>
                    <div class="media-body">
                        <h6 class="media-heading"> Recordatorio </h6>
                        <p>Recuerda que eres responsable del Ticket <b>' . $ticket->folio . '</b></p>
                        <div class="text-muted f-s-11">' . $date->format('d/F/Y g:i A') . '</div>
                    </div>
                </a>
            </li>',
            'icon' => 'fa fa-bullhorn',
            'user_id' => Auth::user()->id
        ];

        $comment = Comment::newComment($ticket, $comment_create, $user);
        if ($comment == null) {
            return response()->json(['errors' => ['message' => 'Lo sentimos pero no fue posible enviar su recordatorio']], 422);
        } else {
            event(new Push($comment_create, $ticket, $user));
            $newComment = Comment::where('id', $comment->id)->with('user')->get()->toArray();
            event(new Comments($newComment[0]));
            return response()->json(['title' => 'Recordatorio', 'msg' => 'Se ha enviado un recordatorio al responsable de este Ticket', 'refresh' => true]);
        }
    }

    /**
     * Returns the name of the contract holder
     *
     * @param $contract
     * @return JsonResponse
     * @throws \Exception
     */
    public function getNameHolder($contract)
    {
        $apiJapam = new ApiJapam();
        $isValidContract = $apiJapam->validateOnlyContract($contract);
        if ($isValidContract[0] == null) {
            return response()->json(["errors" => ["Contrato" => "Lo sentimos, pero no encontramos ningún recibo con la información proporcionada."]])->setStatusCode(422);
        } else {
            return response()->json(["name" => $isValidContract[0]->usuario[0], 'medidor' => $isValidContract[0]->serie_medidor[0]], 200);
        }
    }

    /**
     * Add or remove the subscription to receive notifications of the ticket
     *
     * @param int $ticket_id
     * @param boolean $subscribe
     * @return JsonResponse
     * @throws \Exception
     */
    public function subscribeUnsubscribreTicket($ticket_id, $subscribe) {
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($ticket_id);
            $user = Agent::where('id', Auth::user()->id)->get();
            $date = new Date(Carbon::now());
            if ($subscribe) {
                $ticket->userSubs()->attach($user);
                $content = 'Se ha enlazado al Tiquet para recibir sus notificaciones';
            } else {
                $ticket->userSubs()->detach($user);
                $content = 'Se ha retirado del Tiquet para recibir sus notificaciones';
            }

            $comment_create = [
                'content' => Auth::user()->name . ' ' . $content,
                'html' => '<p>' . Auth::user()->name . ' ' . $content . ' Folio: <strong>' . $ticket->folio . '</strong></p>',
                'html_notification' => '<li class="media">
                    <a href="' . route('tickets.show', $ticket_id) . '">
                        <div class="media-left"><i class="fa fa-bell media-object bg-purple"></i></div>
                        <div class="media-body">
                            <h6 class="media-heading"> Notificaciones </h6>
                            <p>' . Auth::user()->name . ' ' . $content . ' Folio: <strong>' . $ticket->folio . '</strong></p>
                            <div class="text-muted f-s-11">' . $date->format('d/F/Y g:i A') . '</div>
                        </div>
                    </a>
                </li>',
                'icon' => 'fa fa-bell',
                'user_id' => Auth::user()->id
            ];

            $comment = Comment::newComment($ticket, $comment_create, $user[0]);
            if ($comment == null) {
                DB::rollBack();
                return response()->json(['errors' => ['message' => 'Lo sentimos pero no fue posible actualizar su suscripción al Ticket']], 422);
            } else {
                event(new Push($comment_create, $ticket, $user[0]));
                $newComment = Comment::where('id', $comment->id)->with('user')->get()->toArray();
                event(new Comments($newComment[0]));
                DB::commit();
                return response()->json(['msg' => $content, 'title' => 'Suscripción actualizada'], 200);
            }
        } catch (QueryException $e) {
            DB::rollBack();
            \Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage() );
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Search tickets to merge
     *
     * @param $id_ticket
     * @param $tickets
     * @return JsonResponse
     */
    public function searchMergeTicket($id_ticket, $tickets)
    {
        try {
            $tickets = explode(',', $tickets);
            $ticket = Ticket::find($id_ticket);
            $search_tickets = Ticket::select(['id', 'folio', 'content', 'street', 'outside_number', 'inside_number', 'cp', 'status', 'priority_id', 'user_id', 'agent_id', 'category_id', 'incidents_id', 'latitude', 'longitude', 'created_at',
                DB::raw('( 6371 * acos(cos(radians(' . $ticket->latitude . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $ticket->longitude . ')) + sin(radians(' . $ticket->latitude . ')) * sin(radians(latitude)))) AS distance')])
                ->where('id', '!=', $id_ticket)
                ->whereNull('completed_at')
                ->whereIn('folio', $tickets)
                ->doesntHave('mergeSon')
                ->with('priority')->with('agent')->with('user')->with('category')->with('incident')->get();
            return response()->json(['values' => $search_tickets, 'man' => url('img/man.png'), 'image' => \URL::to('../storage/app/public/user/')], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Code: ' . $e->getCode() . '<br/>' . $e->getMessage()], 422);
        }
    }

    /**
     * @param $id_ticket
     * @return JsonResponse
     */
    public function listComments($id_ticket)
    {
        $ticket_merge = Ticket::where('id', $id_ticket)->with('mergeFather.mergeSon')->get();
        $ticket_merge = $this->recursiveMerged([], $ticket_merge[0]->mergeFather);
        if ($ticket_merge == null) {
            $comments = Comment::with('user')->where('ticket_id', $id_ticket)->orderByDesc('created_at')->get()->toArray();
        } else {
            $comments = Comment::with('user')->whereIn('ticket_id', $ticket_merge['tickets_id'])->orWhere('ticket_id', $id_ticket)->orderByDesc('created_at')->get()->toArray();
        }
        return response()->json(['comments' => $comments, 'image_default' => url('img/man.png'), 'image' => \URL::to('../storage/app/public/user/')], 200);
    }

    /**
     * Consultamos la lista de tickes que puedan ser similares al ticket que estamos creando
     *
     * @param $latitude
     * @param $longitude
     * @return JsonResponse
     *
     */
    public function getListSimilarTickets($latitude, $longitude) {
        $similar_tiquets = $this->listSimilarTickets(null, $latitude, $longitude);
        return response()->json(['tickets' => $similar_tiquets, 'image_default' => url('img/man.png'), 'image' => \URL::to('../storage/app/public/user/')], 200);
    }

    /**
     * @param $ticket_id
     * @param $latitude
     * @param $longitude
     * @return Ticket[]|\Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function listSimilarTickets($ticket_id, $latitude, $longitude) {

        return Ticket::select(['id', 'folio', 'content', 'street', 'outside_number', 'inside_number', 'cp', 'status', 'priority_id', 'user_id', 'agent_id', 'category_id', 'incidents_id', 'latitude', 'longitude', 'created_at',
            DB::raw('( 6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(latitude)))) AS distance')])
            ->when($ticket_id, function ($query) use($ticket_id) {
                return $query->where('id', '!=', $ticket_id);
            })
            ->whereNull('completed_at')
            ->having('distance', '<', 0.2)->orderBy('distance')
            ->doesntHave('mergeSon')
            ->with('priority')->with('agent')->with('user')->with('category')->with('incident')->get();
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

    /**
     * Mark ticket as complete.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function complete($id)
    {
        if ($this->permToClose($id) == 'yes') {
            $ticket = $this->tickets->findOrFail($id);
            $ticket->completed_at = Carbon::now();

            if (Setting::grab('default_close_status_id')) {
                $ticket->status_id = Setting::grab('default_close_status_id');
            }

            $subject = $ticket->subject;
            $ticket->save();

            return response()->json(['title' => 'Ticket ' . $ticket->folio . ' atendido', 'msg' => 'Se ha atendido correctamente el Ticket con folio ' . $ticket->folio, 'refresh' => true]);
        }
        return response()->json(['errors' => ['message' => 'Error: Lo sentimos pero no tienes los permisos necesarios para ejecutar la acción']], 422);
    }

    /**
     * Reopen ticket from complete status.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function reopen($id)
    {
        if ($this->permToReopen($id) == 'yes') {
            $ticket = $this->tickets->findOrFail($id);
            $ticket->completed_at = null;

            if (Setting::grab('default_reopen_status_id')) {
                $ticket->status_id = Setting::grab('default_reopen_status_id');
            }

            $incident = Incidents::find($ticket["incidents_id"]);
            $ticket->save();

            return response()->json(['title' => 'Ticket ' . $ticket->folio . ' re-abierto', 'msg' => 'Se ha re-abierto el Ticket con folio ' . $ticket->folio, 'refresh' => true]);

        }
        return response()->json(['errors' => ['message' => 'Error: Lo sentimos pero no tienes los permisos necesarios para ejecutar la acción']], 422);
    }

    /**
     * @param $category_id
     * @param $ticket_id
     * @return string
     */
    public function agentSelectList($category_id, $ticket_id)
    {
        $cat_agents = Category::find($category_id)->agents()->agentsLists();
        if (is_array($cat_agents)) {
            $agents = ['auto' => 'Auto Select'] + $cat_agents;
        } else {
            $agents = ['auto' => 'Auto Select'];
        }

        $selected_Agent = $this->tickets->find($ticket_id)->agent->id;
        $select = '<select class="form-control" id="agent_id" name="agent_id">';
        foreach ($agents as $id => $name) {
            $selected = ($id == $selected_Agent) ? 'selected' : '';
            $select .= '<option value="' . $id . '" ' . $selected . '>' . $name . '</option>';
        }
        $select .= '</select>';

        return $select;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function permToClose($id)
    {
        $close_ticket_perm = Setting::grab('close_ticket_perm');

        if ($this->agent->isAdmin() && $close_ticket_perm['admin'] == 'yes') {
            return 'yes';
        }
        if ($this->agent->isAgent() && $close_ticket_perm['agent'] == 'yes') {
            return 'yes';
        }
        if ($this->agent->isTicketOwner($id) && $close_ticket_perm['owner'] == 'yes') {
            return 'yes';
        }

        return 'no';
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function permToReopen($id)
    {
        $reopen_ticket_perm = Setting::grab('reopen_ticket_perm');
        if ($this->agent->isAdmin() && $reopen_ticket_perm['admin'] == 'yes') {
            return 'yes';
        } elseif ($this->agent->isAgent() && $reopen_ticket_perm['agent'] == 'yes') {
            return 'yes';
        } elseif ($this->agent->isTicketOwner($id) && $reopen_ticket_perm['owner'] == 'yes') {
            return 'yes';
        }

        return 'no';
    }

    /**
     * Calculate average closing period of days per category for number of months.
     *
     * @param int $period
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function monthlyPerfomance($period = 2)
    {
        $categories = Category::all();
        foreach ($categories as $cat) {
            $records['categories'][] = $cat->name;
        }

        for ($m = $period; $m >= 0; $m--) {
            $from = Carbon::now();
            $from->day = 1;
            $from->subMonth($m);
            $to = Carbon::now();
            $to->day = 1;
            $to->subMonth($m);
            $to->endOfMonth();
            $records['interval'][$from->format('F Y')] = [];
            foreach ($categories as $cat) {
                $records['interval'][$from->format('F Y')][] = round($this->intervalPerformance($from, $to, $cat->id), 1);
            }
        }

        return $records;
    }

    /**
     * Calculate the date length it took to solve a ticket.
     *
     * @param Ticket $ticket
     *
     * @return int|false
     */
    public function ticketPerformance($ticket)
    {
        if ($ticket->completed_at == null) {
            return false;
        }

        $created = new Carbon($ticket->created_at);
        $completed = new Carbon($ticket->completed_at);
        $length = $created->diff($completed)->days;

        return $length;
    }

    /**
     * Calculate the average date length it took to solve tickets within date period.
     *
     * @param $from
     * @param $to
     *
     * @return int
     */
    public function intervalPerformance($from, $to, $cat_id = false)
    {
        if ($cat_id) {
            $tickets = Ticket::where('category_id', $cat_id)->whereBetween('completed_at', [$from, $to])->get();
        } else {
            $tickets = Ticket::whereBetween('completed_at', [$from, $to])->get();
        }

        if (empty($tickets->first())) {
            return false;
        }

        $performance_count = 0;
        $counter = 0;
        foreach ($tickets as $ticket) {
            $performance_count += $this->ticketPerformance($ticket);
            $counter++;
        }
        $performance_average = $performance_count / $counter;

        return $performance_average;
    }
}
