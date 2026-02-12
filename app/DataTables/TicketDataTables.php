<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 09/01/2018
 * Time: 01:47 PM
 */

namespace App\DataTables;


use Auth;
use App\Models\Agent;
use App\Models\Ticket;
use function foo\func;
use URL;
use Yajra\Datatables\Services\DataTable;

class TicketDataTables extends DataTable
{
    //protected $completed = false;

    public function completedTickets($completed)
    {
        //$this->completed = $completed;
        return $this;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('agent.name', function ($data) {
                $imageURL = !empty($data->agent->url_image) ? URL::to('/') . '/../storage/app/public/user/' . $data->agent->url_image : url('img/man.png');
                return '<span class="user-image" title="' . $data->agent->name . '">
                        <img src="' . $imageURL . '" alt="' . $data->agent->name . '" style="width: 28px; height: 28px;" />
                    </span>';
            })
            ->editColumn('user.name', function ($data) {
                $imageURL = !empty($data->user->url_image) ? URL::to('/') . '/../storage/app/public/user/' . $data->user->url_image : url('img/man.png');
                return '<span class="user-image" title="' . $data->user->name . '">
                        <img src="' . $imageURL . '" alt="' . $data->user->name . '" style="width: 28px; height: 28px;" />
                    </span>';
            })
            ->editColumn('priority.name', function ($data) {
                return '<span class="label" style="background-color: ' . $data->priority->color . '"> ' . $data->priority->name . '</span>';
            })
            ->editColumn('updated_at', function ($data) {
                if (empty($data->lastComment)) {
                    $imageURL = !empty($data->user->url_image) ? URL::to('/') . '/../storage/app/public/user/' . $data->user->url_image : url('img/man.png');
                    return '<span class="user-image" title="' . $data->user->name . '">
                            <img src="' . $imageURL . '" alt="' . $data->user->name . '" style="width: 28px; height: 28px;" />
                            ' . $data->updated_at->format('d/F/Y h:i:s a') . '
                        </span>';
                } else {
                    $imageURL = !empty($data->lastComment->user->url_image) ? URL::to('/') . '/../storage/app/public/user/' . $data->lastComment->user->url_image : url('img/man.png');
                    return '<span class="user-image" title="' . $data->lastComment->user->name . '">
                            <img src="' . $imageURL . '" alt="' . $data->lastComment->user->name . '" style="width: 28px; height: 28px;" />
                            ' . $data->updated_at->format('d/F/Y h:i:s a') . '
                        </span>';
                }
            })
            ->addColumn('action', 'tickets.datatables_actions')
            ->rawColumns(['agent.name'])
            ->escapeColumns(['agent.name' => 'agent.name'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $completed = $this->request()->get('completed');
        $assigned = $this->request()->get('assigned');
        $generated = $this->request()->get('generated');
        $categories = $this->request()->get('categories');
        $users = $this->request()->get('users');
        $inicio = $this->request()->get('inicio');
        $fin = $this->request()->get('fin');
        $ticket = Ticket::query()->with('priority')->with('agent')->with('user')->with('category')->with('incident');
        if ($assigned)
            $ticket->where('agent_id', Auth::user()->id);
        elseif (!(Agent::isAdmin() || Ticket::isGlobalView()))
            $ticket->where('agent_id', Auth::user()->id);
        if ($generated)
            $ticket->where('user_id', Auth::user()->id);
        if ($completed)
            $ticket->whereNotNull('completed_at');
        else
            $ticket->whereNull('completed_at');
        if (!empty($categories))
            $ticket->where('category_id', $categories);
        if (!empty($users))
            $ticket->where('agent_id', $users);
        if (!empty($inicio))
            $ticket->whereBetween('created_at', [$inicio, $fin]);
        //Filtrar por area cuando no seas
        /*
        if ($user->isAdmin())
            if ($complete)
                $people->complete();
            else
                $people->active();
        elseif ($user->isAgent()) {
            if ($complete)
                $people->complete()->agentUserTickets($user->id);
            else
                $people->active()->agentUserTickets($user->id);
        } else
            if ($complete)
                $people->userTickets($user->id)->complete();
            else
                $people->userTickets($user->id)->active();
        */

        return $this->applyScopes($ticket);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'language' => [
                    'decimal' => trans('lang.table-decimal'),
                    'emptyTable' => trans('lang.table-empty'),
                    'info' => trans('lang.table-info'),
                    'infoEmpty' => trans('lang.table-info-empty'),
                    'infoFiltered' => trans('lang.table-info-filtered'),
                    'infoPostFix' => trans('lang.table-info-postfix'),
                    'thousands' => trans('lang.table-thousands'),
                    'lengthMenu' => trans('lang.table-length-menu'),
                    'loadingRecords' => trans('lang.table-loading-results'),
                    'processing' => trans('lang.table-processing'),
                    'search' => trans('lang.table-search'),
                    'zeroRecords' => trans('lang.table-zero-records'),
                    'paginate' => [
                        'first' => trans('lang.table-paginate-first'),
                        'last' => trans('lang.table-paginate-last'),
                        'next' => trans('lang.table-paginate-next'),
                        'previous' => trans('lang.table-paginate-prev')
                    ],
                    'aria' => [
                        'sortAscending' => trans('lang.table-aria-sort-asc'),
                        'sortDescending' => trans('lang.table-aria-sort-desc')
                    ],
                ],
                'dom' => 'Bfrtip',
                'order' => [[0, 'desc']],
                'pageLength' => 25,
                'responsive' => true,
                'scrollX' => false,
                'buttons' => [
                    ['extend' => 'reload', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-repeat"></i> Recargar'],
                    ['extend' => 'print', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-print"></i> Imprimir'],
                    [
                        'extend' => 'collection',
                        'className' => 'btn btn-xs btn-inverse',
                        'text' => '<i class="fa fa-download"></i> Exportar',
                        'buttons' => [
                            'csv',
                            'excel',
                        ],
                    ],
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            '#' => ['name' => 'folio', 'data' => 'folio'],
            'Motivo' => ['name' => 'incident.name', 'data' => 'incident.name'],
            'Prioridad' => ['name' => 'priority.name', 'data' => 'priority.name'],
            'Estatus' => ['name' => 'status', 'data' => 'status'],
            'Departamento' => ['name' => 'category.name', 'data' => 'category.name'],
            'Creador' => ['name' => 'user.name', 'data' => 'user.name'],
            'Asignado' => ['name' => 'agent.name', 'data' => 'agent.name'],
            'Última Respuesta' => ['name' => 'updated_at', 'data' => 'updated_at']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'tickets';
    }
}