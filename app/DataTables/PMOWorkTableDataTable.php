<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 09/01/2018
 * Time: 01:47 PM
 */

namespace App\DataTables;


use App\Models\PMOWorkTable;
use Auth;
use App\Models\Agent;
use App\Models\Ticket;
use Yajra\Datatables\Services\DataTable;

class PMOWorkTableDataTable extends DataTable
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('agent.name', function ($data) {
                $imageURL = !empty($data->agent->url_image) ? '../storage/app/public/user/' . $data->agent->url_image : url('img/man.png');
                return '<span class="user-image" title="' . $data->agent->name . '">
                        <img src="' . $imageURL . '" alt="' . $data->agent->name . '" style="width: 28px; height: 28px;" />
                    </span>';
            })
            ->editColumn('user.name', function ($data) {
                $imageURL = !empty($data->user->url_image) ? '../storage/app/public/user/' . $data->user->url_image : url('img/man.png');
                return '<span class="user-image" title="' . $data->user->name . '">
                        <img src="' . $imageURL . '" alt="' . $data->user->name . '" style="width: 28px; height: 28px;" />
                    </span>';
            })
            ->editColumn('priority.name', function ($data) {
                return '<span class="label" style="background-color: ' . $data->priority->color . '"> ' . $data->priority->name . '</span>';
            })
            ->editColumn('updated_at', function ($data) {
                if (empty($data->lastComment)) {
                    $imageURL = !empty($data->user->url_image) ? '../storage/app/public/user/' . $data->user->url_image : url('img/man.png');
                    return '<span class="user-image" title="' . $data->user->name . '">
                            <img src="' . $imageURL . '" alt="' . $data->user->name . '" style="width: 28px; height: 28px;" />
                            ' . $data->updated_at . '
                        </span>';

                } else {
                    $imageURL = !empty($data->lastComment->user->url_image) ? '../storage/app/public/user/' . $data->lastComment->user->url_image : url('img/man.png');
                    return '<span class="user-image" title="' . $data->lastComment->user->name . '">
                            <img src="' . $imageURL . '" alt="' . $data->lastComment->user->name . '" style="width: 28px; height: 28px;" />
                            ' . $data->updated_at . '
                        </span>';
                }
            })
            ->addColumn('action', 'p_m_o_work_tables.datatables_actions')
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

        $ticket = Ticket::query()
            ->select("ticketit.id AS ticket_id","ticketit.status","folio","ticketit.updated_at","incidents_id","priority_id","category_id","user_id","agent_id")
            ->with('priority')->with('agent')->with('user')->with('category')->with('incident')->with('lastComment.user')->doesntHave("mergeSon");
        /*->join('users', 'users.id', '=', 'user_id')->join('users', 'users.id', '=', 'agent_id')
        ->join('ticketit_statuses', 'ticketit_statuses.id', '=', 'status_id')->join('ticketit_priorities', 'ticketit_priorities.id', '=', 'category_id');*/
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

        $ticket->with("pmo_work_table")->withCount("pmo_work_table")
        ->orderBy("ticketit.created_at","desc");


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
                'scrollX' => false,
                'buttons' => [
                    ['extend' => 'reload', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-repeat"></i> Recargar'],
                    ['extend' => 'print', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-print"></i> Imprimir'],
                    [
                        'extend'  => 'collection', 'className' => 'btn btn-xs btn-inverse',
                        'text'    => '<i class="fa fa-download"></i> Exportar',
                        'buttons' => [
                            'csv',
                            'excel'
                        ],
                    ],
                    ['extend' => 'colvis', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-eye"></i> Visualizar'],
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
            'Última Respuesta' => ['name' => 'ticketit.updated_at', 'data' => 'updated_at'],
            'Orden _de_Trabajo' => ['name' => 'pmo_work_table.id', 'data' => 'pmo_work_table_count',"defaultContent" => "<b>No tiene OT Asignada</b>"]
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