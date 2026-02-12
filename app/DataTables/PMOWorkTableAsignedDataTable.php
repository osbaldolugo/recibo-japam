<?php

namespace App\DataTables;

use App\Models\Agent;
use App\Models\PMOWorkTable;
use App\Models\Ticket;
use Auth;
use Form;
use Yajra\Datatables\Services\DataTable;

class PMOWorkTableAsignedDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'p_m_o_work_tables.datatables_asignador_actions')
            ->editColumn('status', function ($data) {
                return "<button type='button' name='changeStatus' data-status='". $data->status ."' data-idWorkOrder='". $data->id ."' 
                data-route='".route("pMOWorkTables.change_status")."'
                class='btn btn-primary'>". $data->status ."</button> ";

            })
            /*
            ->editColumn('user.name', function ($data) {
                $imageURL = !empty($data->user->url_image) ? storage_path('app/user/' . $data->user->url_image) : url('img/man.png');
                return '<span class="user-image" title="' . $data->user->name . '">
                        <img src="' . $imageURL . '" alt="' . $data->user->name . '" style="width: 28px; height: 28px;" />
                    </span>';
            })
            ->editColumn('priority.name', function ($data) {
                return '<span class="label" style="background-color: ' . $data->priority->color . '"> ' . $data->priority->name . '</span>';
            })
            ->editColumn('ticketit.updated_at', function ($data) {
                if (empty($data->lastAudit)) {
                    $imageURL = !empty($data->user->url_image) ? storage_path('app/user/' . $data->user->url_image) : url('img/man.png');
                    return '<span class="user-image" title="' . $data->user->name . '">
                            <img src="' . $imageURL . '" alt="' . $data->user->name . '" style="width: 28px; height: 28px;" /><br/>
                            ' . $data->updated_at . '
                        </span>';

                } else {
                    $imageURL = empty($data->lastAudit->user->url_image) ? storage_path('app/user/' . $data->lastAudit->user->url_image) : url('img/man.png');
                    return '<span class="user-image" title="' . $data->lastAudit->user->name . '">
                            <img src="' . $imageURL . '" alt="' . $data->lastAudit->user->name . '" style="width: 28px; height: 28px;" />
                            ' . $data->updated_at . '
                        </span>';
                }
            })*/

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

        $pMOWorkTables = PMOWorkTable::query()->with("pmoEquipment")->with("pmoWork")->with("pmoWorktype")
                            ->with("pmoCategory")->with("ticketit")->with("ticketit.user")->with("ticketit.agent")
                            ->with("ticketit.incident")->with("ticketit.category")->with("user");

        //dd($pMOWorkTables->first()->toArray());

        /*Ticket::query()->leftJoin("pmo_work_table",'pmo_work_table.id_ticketit', '=', 'ticketit.id')
            ->with('priority')->with('agent')->with('user')->with('category')->with('incident')->with('lastAudit.user');*/


        return $this->applyScopes($pMOWorkTables);
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
                'language' => ['url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'],
                'dom' => 'Bfrtip',
                'scrollX' => true,
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
            'Orden_Trabajo' => ['name' => 'folio', 'data' => 'folio'],
            'Ticket' => ['name' => 'ticketit.folio', 'data' => 'ticketit.folio'],
            'Descripción' => ['name' => 'ticketit.content', 'data' => 'ticketit.content'],
            'Estatus' => ['name' => 'status', 'data' => 'status'],
            'Departamento' => ['name' => 'ticketit.category.name', 'data' => 'ticketit.category.name'],
            'Creador' => ['name' => 'ticketit.user.name', 'data' => 'ticketit.user.name'],
            'Asignado' => ['name' => 'ticketit.agent.name', 'data' => 'ticketit.agent.name'],
            'Trabajo' => ['name' => 'pmo_work.description', 'data' => 'pmo_work.description'],
            'Tipo_trabajo' => ['name' => 'pmo_worktype.type', 'data' => 'pmo_worktype.type'],
            //'Última Actualización' => ['name' => 'ticketit.updated_at', 'data' => 'ticketit.updated_at'],
            //'id_user' => ['name' => 'id_user', 'data' => 'id_user'],
            //'folio' => ['name' => 'folio', 'data' => 'folio'],
            /*'Folio Trabajo' => ['name' => 'id_work', 'data' => 'id_work'],*/
            /*'Codigo_Equipo' => ['name' => 'pmo_equipment.equipment_code', 'data' => 'pmo_equipment.equipment_code'],*/
            //'Visto Bueno' => ['name' => 'vo_bo', 'data' => 'vo_bo'],
            //'Estado' => ['name' => 'status', 'data' => 'status'],
            //'date_end' => ['name' => 'date_end', 'data' => 'date_end'],
            //'Fecha_limite' => ['name' => 'deadline', 'data' => 'deadline']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pMOWorkTables';
    }
}
