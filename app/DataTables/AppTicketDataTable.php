<?php

namespace App\DataTables;

use App\Models\AppTicket;
use Form;
use Yajra\Datatables\Services\DataTable;

class AppTicketDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('user_name', function ($data) {
                if (!empty($data->user_name)) {
                    return '<div class="user-image text-center" title="' . $data->user_name . '">
                        <img src="' . url('img/icon_japam.png') . '" alt="' . $data->user_name . '" style="width: 28px; height: 28px;"/>
                        <br/><span>' . $data->user_name . ' ' . $data->user_last_name_1 . '</span>
                    </div>';
                } elseif (!empty($data->unlogged_name)) {
                    return '<div class="user-image text-center" title="' . $data->unlogged_name . '">
                        <img src="' . url('img/man.png') . '" alt="' . $data->unlogged_name . '" style="width: 28px; height: 28px;" />
                        <br/><span>' . $data->unlogged_name . ' ' . $data->unlogged_last_name_1 . '</span>
                    </div>';
                } else {
                    return '<div class="user-image text-center" title="Anónimo">
                        <img src="' . url('img/incognito.png') . '" alt="Anonimo" style="width: 28px; height: 28px;" />
                        <br/><span>Anónimo</span>
                    </div>';
                }
            })
            ->editColumn('unlogged_name', function ($data) {
                if (!empty($data->user_name)) {
                    return $data->user_name;
                } elseif (!empty($data->unlogged_name)) {
                    return $data->unlogged_name;
                } else {
                    return 'Anónimo';
                }
            })
            ->editColumn('user_phone', function ($data) {
                if(!empty($data->user_phone)){
                    return $data->user_phone;
                } elseif(!empty($data->unlogged_phone)) {
                    return $data->unlogged_phone;
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('d/F/Y h:i:s a');
            })
            ->editColumn('url_image', function ($data) {
                if (empty($data->url_image))
                    return '<div class="text-center"><span class="badge badge-warning text-uppercase f-s-13">NA/IMAGEN</span></div>';
                else
                    return '<img src="' . \URL::to('/../storage/app/japam/app_ticket/' . $data->url_image) . '" style="max-width: 60px; max-height: 60px" class="show-detail-image cursor-pointer">';
            })
            ->addColumn('action', 'app_tickets.datatables_actions')
            ->rawColumns(['user_name'])
            ->escapeColumns(['user_name' => 'user_name'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $type = $this->request()->get("type");
        $appTickets = AppTicket::query()->select(['app_ticket.id', 'type', 'address', 'description', 'url_image', 'app_user.phone_number AS user_phone', 'people.name AS user_name', 'people.last_name_1 AS user_last_name_1', 'app_ticket.created_at',
            'people.last_name_2 AS user_last_name_2', 'people_unlogged.name AS unlogged_name', 'people_unlogged.last_name_1 AS unlogged_last_name_1', 'people_unlogged.last_name_2 AS unlogged_last_name_2', 'people_unlogged.phone_number AS unlogged_phone'])
            ->leftJoin('app_user', 'app_ticket.app_user_id','=', 'app_user.id')->leftJoin('people', 'app_user.people_id', '=', 'people.id')
            ->leftJoin('people_unlogged', 'app_ticket.people_unlogged_id', '=', 'people_unlogged.id')
            ->doesntHave("ticket");
        if ($type != 'all')
            $appTickets->where('type', $type);
        return $this->applyScopes($appTickets);
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
                'pageLength'=> 25,
                'order' => [[0, 'desc']],
                'responsive'=>true,
                'dom' => 'Bfrtip',
                'language' => ['url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'],
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
                    ]
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
            'Pre-ticket' => ['name' => 'app_ticket.id', 'data' => 'id'],
            'Usuario' => ['name' => 'people.name', 'data'=>'user_name'],
            'Teléfono' => ['name' => 'app_user.phone_number', 'data'=>'user_phone'],
            'Imagen' => ['name' => 'url_image', 'data' => 'url_image'],
            'Descripción' => ['name' => 'description', 'data' => 'description'],
            'Dirección' => ['name' => 'address', 'data' => 'address'],
            'Tipo' => ['name' => 'type', 'data' => 'type'],
            'Fecha' => ['name' => 'created_at', 'data' => 'created_at'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'appTickets';
    }
}
