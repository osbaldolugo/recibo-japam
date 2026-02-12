<?php

namespace App\Http\Controllers;

use App\DataTables\PMOWorkTableAsignedDataTable;
use App\DataTables\PMOWorkTableDataTable;
use App\Http\Helpers\LaravelVersion;
use App\Http\Requests;
use App\Http\Requests\CreatePMOWorkTableRequest;
use App\Http\Requests\UpdatePMOWorkTableRequest;
use App\Models\Agent;
use App\Models\AppTicket;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Incidents;
use App\Models\PMOEquipment;
use App\Models\PMOWork;
use App\Models\PMOWorker;
use App\Models\PMOWorkTable;
use App\Models\PMOWorkType;
use App\Models\Priority;
use App\Models\Sector;
use App\Models\Status;
use App\Models\Suburb;
use App\Models\Ticket;
use App\Models\TicketitsApp;
use App\Models\Export\WorkOrderPDF;
use App\Repositories\PMOWorkTableFinishRepository;
use App\Repositories\PMOWorkTableRepository;
use Cache;
use DB;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class PMOWorkTableController extends AppBaseController
{
    /** @var  PMOWorkTableRepository */
    protected $tickets;
    protected $agent;

    public function __construct(Ticket $tickets, Agent $agent ,PMOWorkTableRepository $pMOWorkTableRepo, PMOWorkTableFinishRepository $pMOWorkTableFinishRepo)
    {
        //$this->middleware('ResAccess', ['only' => ['show']]);
        $this->middleware('IsAgent', ['only' => ['edit', 'update']]);
        $this->middleware('IsAdmin', ['only' => ['destroy']]);

        $this->tickets = $tickets;
        $this->agent = $agent;
        $this->pMOWorkTableRepository = $pMOWorkTableRepo;
        $this->pMOWorkTableFinishRepository = $pMOWorkTableFinishRepo;
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
     * Display a listing of the PMOWorkTable.
     *
     * @param PMOWorkTableDataTable $pMOWorkTableDataTable
     * @return Response
     */
    public function index(PMOWorkTableDataTable $pMOWorkTableDataTable)
    {
        $isAdmin = Agent::isAdmin();
        //$isAgent = Agent::isAgent(Auth::user()->id);
        $categories = Category::all()->pluck('name', 'id');
        $users = Agent::all()->pluck('name', 'id');
        $permits = Ticket::isGlobalView(); //
        \View::share(['isAdmin' => $isAdmin, 'permits' => $permits, 'department' => $categories, 'users' => $users]);
        return $pMOWorkTableDataTable->render('p_m_o_work_tables.index');
    }


    /**
     * Display a listing of the PMOWorkTable.
     *
     * @param PMOWorkTableDataTable $pMOWorkTableDataTable
     * @return Response
     */
    public function index_asignados(PMOWorkTableAsignedDataTable $pMOWorkTableDataTable)
    {
        $categories = Category::all()->pluck('name', 'id');
        $ticket = Ticket::all()->pluck('folio', 'id');
        $users = Agent::all()->pluck('name', 'id');
        $isAdmin = Agent::isAdmin();
        \View::share(['isAdmin' => $isAdmin,'tickets'=> $ticket, 'department' => $categories, 'users' => $users]);

        return $pMOWorkTableDataTable->render('p_m_o_work_tables.index_asignados');
    }


    /**
     * Download the PMOWorkTable.
     *
     * @param PMOWorkTableDataTable $pMOWorkTableDataTable
     * @return Response
     */
    public function downloadFile(Request $request)
    {

        $id = $request->input("id");
        $ticket_id = $request->input("ticket_id");

        $orderWork = PMOWorkTable::find($id);

        if (!is_dir(base_path() . "/storage/app/workOrder")) {
            $path = base_path() . "/storage/app/workOrder";
            \File::makeDirectory($path, $mode = 0777, true, true);
            return response()->json(["success"=>0,"msg","Error 1"]);
        }else{
            if (!is_dir(base_path() . "/storage/app/workOrder/" . $orderWork["ticket_id"] . '/')) {
                $path = base_path() . "/storage/app/workOrder/" . $orderWork["ticket_id"] . '/';
                \File::makeDirectory($path, $mode = 0777, true, true);
                return response()->json(["success"=>0,"msg","Error 2"]);

            }
        }

        $path = \URL::to("../storage/app/workOrder/" . $orderWork["ticket_id"])  . '/'.$id.".pdf";


        return response()->json(["success"=>1,"url"=>$path]);


    }

    /**
     * change_status the PMOWorkTable.
     *
     * @param PMOWorkTableDataTable $pMOWorkTableDataTable
     * @return Response
     */
    public function change_status(Request $request)
    {

        $id = $request->input("id");
        $status = $request->input("status");


        $orderWork = PMOWorkTable::find($id);

        $orderWork->status($status);
        $orderWork->save();

        if (!empty($orderWork)) {
            return response()->json(["success"=>1,"msg"=>"Estatus cambiado correctamente"]);
        }


    }

    /**
     * Show the form for creating a new PMOWorkTable.
     *
     * @return Response
     */
    public function create()
    {
        return view('p_m_o_work_tables.create');
    }

    /**
     * Store a newly created PMOWorkTable in storage.
     *
     * @param CreatePMOWorkTableRequest $request
     *
     * @return Response
     */
    public function store(CreatePMOWorkTableRequest $request)
    {
        $input = $request->all();

        $input["user_id"] = Auth::user()->id;

        $pMOWorkTable = $this->pMOWorkTableRepository->create($input);

        $folio = PMOWorkTable::max('folio');
        if($folio == null){
            $pMOWorkTable->folio = 1;
        }else {
            $pMOWorkTable->folio = $folio+1;
        }

        $pMOWorkTable->save();


        $pmoWork = PMOWorkTable::where("id","=",$pMOWorkTable["id"])->with("pmoEquipment")->with("pmoWork")->with("pmoCategory")->first();

        return response()->json(array("success"=>1,
                                    "msg"=>"Se creo la nueva Orden de Trabajo",
                                    "pmoWork" => $pmoWork));
    }

    /**
     * Store a newly created PMOWorkTable in storage.
     *
     * @param CreatePMOWorkTableRequest $request
     *
     * @return Response
     */
    public function createPDF(Request $request)
    {
        $input = $request->all();

        $input["user_id"] = Auth::user()->id;

        $folio = PMOWorkTable::max('folio');

        $ticket = Ticket::where("id","=",$input["ticket_id"])->with('appTicket.peopleUnlogged')
            ->with('appTicket.appUser.people')->with('comments.user')->with('suburb')->with('suburb.sector')->with('priority')->with('agent')
            ->with('user')->with('category')->with('incident')->get()->first();

        $pmoWork = PMOWorkTable::where("id","=",$input["id_pmo_work_table"])->with("pmoEquipment")
            ->with("pmoWork")->with("pmoWorktype")->with("pmoCategory")->with("user")->get()->first();

        //try {

            $pdf = WorkOrderPDF::workerOrderPDF($ticket,$pmoWork);


            //return response()->download('../storage/app/workOrder/' . $input["id_pmo_work_table"] . '/' . $input["id_pmo_work_table"] . '.pdf')->deleteFileAfterSend(true);
            return response()->json([
                "success" => 1,
                "url" => $pdf,
                "msg" => "Correcto"
            ]);
            //return response()->download(storage_path('exports') . '/OCFacturaBot/' . $excel['file']);
/*        } catch (\Exception $e) {

            return response()->json([
                "success" => 0,
                "error" => $e,
                "url" => storage_path('app') . '/workOrder/' . $input["ticket_id"] . '/' . $input["id_pmo_work_table"] . '.pdf',
                "msg" => "Incorrecto"
            ]);

        }
*/
    }


    /**
     * Display the specified PMOWorkTable.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ticket = $this->tickets->findOrFail($id);

        list($priority_lists, $category_lists, $status_lists) = $this->PCS();

        $close_perm = $this->permToClose($id);
        $reopen_perm = $this->permToReopen($id);

        $cat_agents = Category::find($ticket->category_id)->agents()->agentsLists();
        if (is_array($cat_agents)) {
            $agent_lists = ['auto' => 'Selecci¨®n autom¨¢tica'] + $cat_agents;
        } else {
            $agent_lists = ['auto' => 'Selecci¨®n autom¨¢tica'];
        }
        //dd($agent_lists);

        //$comments = $ticket->comments()->paginate(Setting::grab('paginate_items'));
        $ticket = Ticket::where('id', $id)->with('appTicket.peopleUnlogged.receipt')->with('comments.user')->with('suburb')
            ->with('priority')->with('agent')->with('user')->with('category')->with('incident')->get()->first();
//        dd(Carbon::now()->diffInDays($ticket->created_at));
//        dd($ticket->audits[0]->created_at->diffForHumans());


        $all_categories = Category::has('agents')->get();
        $myCategories = Category::whereHas('agents', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->get();

//        dd(Carbon::now()->diffForHumans());
//        dd($ticket->audits[0]->created_at->diffForHumans());
//        dd($ticket);
        $ticket_merge = Ticket::where('id', $id)->with('mergeFather.mergeSon')->get();
        $ticket_merge = $this->recursiveMerged([], $ticket_merge[0]->mergeFather);
//        dd($ticket_merge);
        $tickets_merged = empty($ticket_merge) ? null : $ticket_merge['son'];
        if ($ticket_merge == null) {
            $comments = Comment::with('user')->where('ticket_id', $id)->orderByDesc('created_at')->get();
        } else {
            $comments = Comment::with('user')->whereIn('ticket_id', $ticket_merge['tickets_id'])->orWhere('ticket_id', $id)->orderByDesc('created_at')->get();
        }
        //dd($comments[0]);
//        dd($tickets_merged[0]->incident->name);
        if ($ticket->mergeSon == null) {
            $similar_tickets = Ticket::select(['id', 'folio', 'content', 'street', 'outside_number', 'inside_number', 'cp', 'status', 'priority_id', 'user_id', 'agent_id', 'category_id', 'incidents_id', 'latitude', 'longitude', 'created_at',
                DB::raw('( 6371 * acos(cos(radians(' . $ticket->latitude . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $ticket->longitude . ')) + sin(radians(' . $ticket->latitude . ')) * sin(radians(latitude)))) AS distance')])
                ->where('id', '!=', $id)
                ->having('distance', '<', 0.2)->orderBy('distance')
                ->doesntHave('mergeSon')
                ->with('priority')->with('agent')->with('user')->with('category')->with('incident')->get();
            //dd($similar_tickets);
            return view('kordy.tickets.show', compact('ticket', 'all_categories', 'myCategories', 'similar_tickets', 'tickets_merged', 'comments'));
        } else {
            return view('kordy.tickets.show', compact('ticket', 'tickets_merged', 'comments'));
        }
    }

    /**
     * Show the form for editing the specified PMOWorkTable.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pMOWorkTable = $this->pMOWorkTableRepository->findWithoutFail($id);

        $ticket = Ticket::find($id);

        $ticket_app = TicketitsApp::join("app_ticket","ticketits_app.app_ticket_id","=","app_ticket.id")->where("ticket_id",$ticket["id"])->first();

        if (empty($ticket)) {
            Flash::error('Error elemento no encontrado');
            return redirect(route('pMOWorkTables.index'));
        }

        return view('p_m_o_work_tables.edit')
            ->with('pMOWorkTable', $pMOWorkTable)
            ->with('ticket', $ticket)
            ->with('ticket_app', $ticket_app);
    }

    /**
     * Update the specified PMOWorkTable in storage.
     *
     * @param  int              $id
     * @param UpdatePMOWorkTableRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePMOWorkTableRequest $request)
    {
        $pMOWorkTable = $this->pMOWorkTableRepository->findWithoutFail($id);

        if (empty($pMOWorkTable)) {
            Flash::error('P M O Work Table not found');

            return redirect(route('pMOWorkTables.index'));
        }

        $pMOWorkTable = $this->pMOWorkTableRepository->update($request->all(), $id);

        Flash::success('P M O Work Table updated successfully.');

        return redirect(route('pMOWorkTables.index'));
    }

    /**
     * Remove the specified PMOWorkTable from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pMOWorkTable = $this->pMOWorkTableRepository->findWithoutFail($id);

        if (empty($pMOWorkTable)) {
            Flash::error('P M O Work Table not found');

            return redirect(route('pMOWorkTables.index'));
        }

        $this->pMOWorkTableRepository->delete($id);

        Flash::success('P M O Work Table deleted successfully.');

        return redirect(route('pMOWorkTables.index'));
    }

    /**
     * View to Mapping the WorkOrder
     *
     * @param  int $id
     *
     * @return Response
     */
    public function mappingCreate($id)
    {
        $pMOWorkTable = $this->pMOWorkTableRepository->findWithoutFail($id);

        $ticket = $this->tickets->findOrFail($id);
        $sectors = Sector::get()->pluck("name","id");
        $all_categories = Category::has('agents')->get();

        list($priority_lists, $category_lists, $status_lists) = $this->PCS();

        //dd($agent_lists);

        //$comments = $ticket->comments()->paginate(Setting::grab('paginate_items'));
        $ticket = Ticket::where('id', $id)->with('appTicket.peopleUnlogged.receipt')->with('comments.user')->with('suburb')
            ->with('priority')->with('agent')->with('user')->with('category')->with('incident')->get()->first();

        $all_categories = Category::has('agents')->get();
        $myCategories = Category::whereHas('agents', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->get();

//        dd(Carbon::now()->diffForHumans());
//        dd($ticket->audits[0]->created_at->diffForHumans());
//        dd($ticket);
        $ticket_merge = Ticket::where('id', $id)->with('mergeFather.mergeSon')->get();
        $ticket_merge = $this->recursiveMerged([], $ticket_merge[0]->mergeFather);
//        dd($ticket_merge);
        $tickets_merged = empty($ticket_merge) ? null : $ticket_merge['son'];
        if ($ticket_merge == null) {
            $comments = Comment::with('user')->where('ticket_id', $id)->orderByDesc('created_at')->get();
        } else {
            $comments = Comment::with('user')->whereIn('ticket_id', $ticket_merge['tickets_id'])->orWhere('ticket_id', $id)->orderByDesc('created_at')->get();
        }
        //dd($comments[0]);
//        dd($tickets_merged[0]->incident->name);
        if ($ticket->mergeSon == null) {
            $similar_tickets = Ticket::select(['id', 'folio', 'content', 'street', 'outside_number', 'inside_number', 'cp', 'status', 'priority_id', 'user_id', 'agent_id', 'category_id', 'incidents_id', 'latitude', 'longitude', 'created_at',
                \DB::raw('( 6371 * acos(cos(radians(' . $ticket->latitude . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $ticket->longitude . ')) + sin(radians(' . $ticket->latitude . ')) * sin(radians(latitude)))) AS distance')])
                ->where('id', '!=', $id)
                ->having('distance', '<', 0.2)->orderBy('distance')
                ->doesntHave('mergeSon')
                ->with('priority')->with('agent')->with('user')->with('category')->with('incident')->get();
            //dd($similar_tickets);
            return view('p_m_o_work_tables.mappingCreate', compact('sectors','ticket', 'all_categories', 'myCategories', 'similar_tickets', 'tickets_merged', 'comments'));
        } else {
            return view('p_m_o_work_tables.mappingCreate', compact('sectors','ticket', 'tickets_merged', 'comments'));
        }


        return view('p_m_o_work_tables.mappingCreate',
            compact('ticket', 'status_lists', 'priority_lists', 'sectors','category_lists', 'agent_lists',
                'close_perm', 'reopen_perm', 'all_categories'));
    }

    /**
     * View to Generate the WorkOrder
     *
     * @param  int $id
     *
     * @return Response
     */
    public function orderWorkCreate($id)
    {

        /*$pMOWorkTable = $this->pMOWorkTableRepository->findWithoutFail($id);*/

        $ticket = $this->tickets->findOrFail($id);
        $sectors = Sector::get()->pluck("name","id");


        list($priority_lists, $category_lists, $status_lists) = $this->PCS();

        //dd($agent_lists);
        $PMOWorks = PMOWork::get()->pluck("description","id");
        $PMOWorkers = PMOWorker::get()->pluck("name","id");
        $categories = Category::get()->pluck("name","id");
        $PMOWorkTypes = PMOWorkType::get()->pluck("type","id");
        $PMOEquipments = PMOEquipment::get()->pluck("description","id");

        //$comments = $ticket->comments()->paginate(Setting::grab('paginate_items'));
        $ticket = Ticket::where('id', $id)->with('appTicket.peopleUnlogged.receipt')->with('comments.user')->with('suburb')
            ->with('priority')->with('agent')->with('user')->with('category')->with('incident')->with('pmo_worktable')->get()->first();
//        dd(Carbon::now()->diffInDays($ticket->created_at));
//        dd($ticket->audits[0]->created_at->diffForHumans());
        $all_categories = Category::has('agents')->get();
        $myCategories = Category::whereHas('agents', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->get();

//        dd(Carbon::now()->diffForHumans());
//        dd($ticket->audits[0]->created_at->diffForHumans());
//        dd($ticket);
        $ticket_merge = Ticket::where('id', $id)->with('mergeFather.mergeSon')->get();
        $ticket_merge = $this->recursiveMerged([], $ticket_merge[0]->mergeFather);
//        dd($ticket_merge);
        $tickets_merged = empty($ticket_merge) ? null : $ticket_merge['son'];
        if ($ticket_merge == null) {
            $comments = Comment::with('user')->where('ticket_id', $id)->orderByDesc('created_at')->get();
        } else {
            $comments = Comment::with('user')->whereIn('ticket_id', $ticket_merge['tickets_id'])->orWhere('ticket_id', $id)->orderByDesc('created_at')->get();
        }
        //dd($comments[0]);
//        dd($tickets_merged[0]->incident->name);
        if ($ticket->mergeSon == null) {
            $similar_tickets = Ticket::select(['id', 'folio', 'content', 'street', 'outside_number', 'inside_number', 'cp', 'status', 'priority_id', 'user_id', 'agent_id', 'category_id', 'incidents_id', 'latitude', 'longitude', 'created_at',
                DB::raw('( 6371 * acos(cos(radians(' . $ticket->latitude . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $ticket->longitude . ')) + sin(radians(' . $ticket->latitude . ')) * sin(radians(latitude)))) AS distance')])
                ->where('id', '!=', $id)
                ->having('distance', '<', 0.2)->orderBy('distance')
                ->doesntHave('mergeSon')
                ->with('priority')->with('agent')->with('user')->with('category')->with('incident')->get();
            //dd($similar_tickets);
            return view('p_m_o_work_tables.workCreate', compact( 'PMOWorks','categories','PMOWorkers','PMOWorkTypes','PMOEquipments','ticket', 'all_categories', 'myCategories', 'similar_tickets', 'tickets_merged', 'comments'));
        } else {
            return view('p_m_o_work_tables.workCreate', compact( 'PMOWorks','categories','PMOWorkers','PMOWorkTypes','PMOEquipments','ticket', 'tickets_merged', 'comments'));
        }


        return view('p_m_o_work_tables.workCreate',
            compact('ticket', 'status_lists', 'priority_lists', 'PMOWorks','categories','PMOWorkers','PMOWorkTypes','PMOEquipments','category_lists', 'agent_lists',
                'close_perm', 'reopen_perm','all_categories'));

    }


    /**
     * View to Generate the WorkClose
     *
     * @param  int $id
     *
     * @return Response
     */
    public function orderWorkClose($id)
    {

        /*$pMOWorkTable = $this->pMOWorkTableFinishRepository->findWithoutFail($id);*/

        $ticket = $this->tickets->findOrFail($id);
        $sectors = Sector::get()->pluck("name","id");

        list($priority_lists, $category_lists, $status_lists) = $this->PCS();

        //dd($agent_lists);
        $PMOWorks = PMOWork::get()->pluck("description","id");
        $PMOWorkers = PMOWorker::get()->pluck("name","id");
        $categories = Category::get()->pluck("name","id");
        $PMOWorkTypes = PMOWorkType::get()->pluck("type","id");
        $PMOEquipments = PMOEquipment::get()->pluck("description","id");

        //$comments = $ticket->comments()->paginate(Setting::grab('paginate_items'));
        $ticket = Ticket::where('id', $id)->with('appTicket.peopleUnlogged.receipt')->with('comments.user')->with('suburb')
            ->with('priority')->with('agent')->with('user')->with('category')->with('incident')->with('pmo_worktable')->get()->first();
//        dd(Carbon::now()->diffInDays($ticket->created_at));
//        dd($ticket->audits[0]->created_at->diffForHumans());
        $all_categories = Category::has('agents')->get();
        $myCategories = Category::whereHas('agents', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->get();

//        dd(Carbon::now()->diffForHumans());
//        dd($ticket->audits[0]->created_at->diffForHumans());
//        dd($ticket);
        $ticket_merge = Ticket::where('id', $id)->with('mergeFather.mergeSon')->get();
        $ticket_merge = $this->recursiveMerged([], $ticket_merge[0]->mergeFather);
//        dd($ticket_merge);
        $tickets_merged = empty($ticket_merge) ? null : $ticket_merge['son'];
        if ($ticket_merge == null) {
            $comments = Comment::with('user')->where('ticket_id', $id)->orderByDesc('created_at')->get();
        } else {
            $comments = Comment::with('user')->whereIn('ticket_id', $ticket_merge['tickets_id'])->orWhere('ticket_id', $id)->orderByDesc('created_at')->get();
        }
        //dd($comments[0]);
//        dd($tickets_merged[0]->incident->name);
        if ($ticket->mergeSon == null) {
            $similar_tickets = Ticket::select(['id', 'folio', 'content', 'street', 'outside_number', 'inside_number', 'cp', 'status', 'priority_id', 'user_id', 'agent_id', 'category_id', 'incidents_id', 'latitude', 'longitude', 'created_at',
                DB::raw('( 6371 * acos(cos(radians(' . $ticket->latitude . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $ticket->longitude . ')) + sin(radians(' . $ticket->latitude . ')) * sin(radians(latitude)))) AS distance')])
                ->where('id', '!=', $id)
                ->having('distance', '<', 0.2)->orderBy('distance')
                ->doesntHave('mergeSon')
                ->with('priority')->with('agent')->with('user')->with('category')->with('incident')->get();
            //dd($similar_tickets);
            return view('p_m_o_work_tables.workClose', compact( 'PMOWorks','categories','PMOWorkers','PMOWorkTypes','PMOEquipments','ticket', 'all_categories', 'myCategories', 'similar_tickets', 'tickets_merged', 'comments'));
        } else {
            return view('p_m_o_work_tables.workClose', compact( 'PMOWorks','categories','PMOWorkers','PMOWorkTypes','PMOEquipments','ticket', 'tickets_merged', 'comments'));
        }


        return view('p_m_o_work_tables.workClose',
            compact('ticket', 'status_lists', 'priority_lists', 'PMOWorks','categories','PMOWorkers','PMOWorkTypes','PMOEquipments','category_lists', 'agent_lists',
                'close_perm', 'reopen_perm','all_categories'));

    }

    /**
     * Show the form for editing the specified PMOWorkTable.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function getWorkOrder($id)
    {
        $pMOWorkTable = $this->pMOWorkTableRepository->findWithoutFail($id);
        
        if (empty($pMOWorkTable)) {
            return response()->json(array("success"=>1, "message"=> "No se encontro el ID"));
        }

        return response()->json(array("success"=>1, "data"=> $pMOWorkTable));
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


}
