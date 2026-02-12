<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 26/03/2018
 * Time: 10:05 AM
 */

namespace App\DataTables;


use Auth;
use App\Models\Agent;
use URL;
use Yajra\Datatables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('url_image', function ($data) {
                $imageURL = !empty($data->url_image) ? URL::to('/') . '/../storage/app/public/user/' . $data->url_image : url('img/man.png');
                return '<span class="user-image" title="' . $data->name . '">
                        <img src="' . $imageURL . '" alt="' . $data->name . '" style="width: 28px; height: 28px;" />
                    </span>';
            })
            ->editColumn('ticketit_admin', function ($data) {
                return '<div class="text-center">' . \Form::input('checkbox', 'is_admin', $data->id, ['class' => 'is-admin-all is-admin', 'checked' => $data->ticketit_admin ? true : false]) . '</div>';
            })
            ->editColumn('ticketit_agent', function ($data) {
                return '<div class="text-center">' . \Form::input('checkbox', 'is_agent', $data->id, ['class' => 'is-agent-all is-agent', 'checked' => $data->ticketit_agent ? true : false]) . '</div>';
            })
            ->addColumn('action', 'admin.datatables_actions')
            ->rawColumns(['url_image'])
            ->escapeColumns(['url_image' => 'url_image'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $deleted = $this->request()->get("deleted");
        if (!$deleted)
            $people = Agent::query();
        else
            $people = Agent::query()->withTrashed();
        return $this->applyScopes($people);
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
            ->addAction(['width' => '15%'])
            ->ajax('')
            ->parameters([
                'language' => ['url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'],
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'buttons' => [
                    ['extend' => 'reload', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-repeat"></i> Recargar'],
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
            '#' => ['name' => 'id', 'data' => 'id'],
            'Imagen' => ['name' => 'url_image', 'data' => 'url_image'],
            'Nombre' => ['name' => 'name', 'data' => 'name'],
            'Email' => ['name' => 'email', 'data' => 'email'],
            'Administrador' => ['name' => 'ticketit_admin', 'data' => 'ticketit_admin'],
            'Jefe Departamento' => ['name' => 'ticketit_agent', 'data' => 'ticketit_agent']
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