<?php

namespace App\DataTables;

use App\Models\AppTicket;
use App\Models\AppUser;
use App\Models\PeopleUnlogged;
use DB;
use function foo\func;
use Form;
use Yajra\Datatables\Services\DataTable;

class AppUserDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('Reporte', function ($data){
                return "<span>"+$data["app_ticket"]+"</span>";
            })
            //->addColumn('action', 'app_users.datatables_actions')
            ->rawColumns(['reporte'])
            ->escapeColumns(['reporte' => 'reporte'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {

        $appTickets = AppTicket::query()->select("app_ticket.id")->get()->toArray();

        $appUsers = AppUser::query()->join("people","people.id","=","app_user.people_id")
            ->select(DB::raw('COUNT(app_ticket.id) as countTicket'),"app_user.id","people.name","email","phone_number","created_at","updated_at")
            ->leftJoin("app_ticket", function ($join) use ($appTickets) {
                $join->on('app_ticket.app_user_id', '=','app_user.id')
                    ->whereIn('app_ticket.id', $appTickets);
            })->groupBy('app_ticket.id');


        return $this->applyScopes($appUsers);
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
                'scrollX' => false,
                'buttons' => [
                    ['extend' => 'print', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-print"></i> Imprimir'],
                    ['extend' => 'reload', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-repeat"></i> Recargar'],
                    [
                         'extend'  => 'collection','className' => 'btn btn-xs btn-inverse',
                         'text'    => '<i class="fa fa-download"></i> Exportar',
                         'buttons' => [
                             'csv',
                             'excel',
                             'pdf',
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
            'Id' => ['name' => 'app_user.id', 'data' => 'app_user.id'],
            'nombre' => ['name' => 'people.name', 'data' => 'people.name'],
            'email' => ['name' => 'email', 'data' => 'email'],
            'Numero_Telefono' => ['name' => 'phone_number', 'data' => 'phone_number'],
            'Reporte' => ['name'=> 'reporte'],
            'Creado' => ['name' => 'created_at', 'data' => 'created_at'],
            'Ultima_Actualización' => ['name' => 'updated_at', 'data' => 'updated_at']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'appUsers';
    }
}
