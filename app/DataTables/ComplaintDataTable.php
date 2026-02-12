<?php

namespace App\DataTables;

use App\Models\Complaint;
use URL;
use Yajra\Datatables\Services\DataTable;

class ComplaintDataTable extends DataTable
{

    protected $type = "";

    public function typeComplaint($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('name', function ($data) {
                if (!empty($data->people)) {
                    return '<div class="user-image text-center" title="' . $data->people . '">
                        <img src="' . url('img/icon_japam.png') . '" alt="' . $data->people . '" style="width: 28px; height: 28px;" />
                        <br/><span>' . $data->people . '</span>
                    </div>';
                } elseif (!empty($data->name)) {
                    return '<div class="user-image text-center" title="' . $data->name . '">
                        <img src="' . url('img/man.png') . '" alt="' . $data->name . '" style="width: 28px; height: 28px;" />
                        <br/><span>' . $data->name . ' ' . $data->last_name_1 . '</span>
                    </div>';
                } else {
                    return '<div class="user-image text-center" title="Anónimo">
                        <img src="' . url('img/incognito.png') . '" alt="Anonimo" style="width: 28px; height: 28px;" />
                        <br/><span>Anónimo</span>
                    </div>';
                }
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('d/F/Y h:i:s a');
            })
            ->editColumn('type', function ($data) {
                if ($data->type == 'cita')
                    return '<div class="text-center"><span class="label label-warning text-uppercase f-s-13">' . $data->type . '</span></div>';
                else
                    return '<div class="text-center"><span class="label label-primary text-uppercase f-s-13">' . $data->type . '</span></div>';
            })
            //->addColumn('action', 'complaints.datatables_actions')
            ->rawColumns(['name', 'created_at'])
            ->escapeColumns(['name' => 'name', 'created_at' => 'created_at'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $complains = Complaint::query()->select('complaint.id', 'description', 'type', 'complaint.created_at', 'people.name AS people', 'people.last_name_1 AS people_fisrt', 'people.last_name_2 AS people_second', 'people_unlogged.name', 'people_unlogged.last_name_1', 'people_unlogged.last_name_2')
            ->leftJoin('app_user', 'complaint.app_user_id', '=', 'app_user.id')->leftJoin('people', 'app_user.people_id', '=', 'people.id')
            ->leftJoin('people_unlogged', 'complaint.people_unlogged_id', '=', 'people_unlogged.id')->where("type", "=", $this->type)->groupBy('complaint.id');

        return $this->applyScopes($complains);
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
            //->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'language' => ['url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'],
                'dom' => 'Bfrtip',
                'order' => [[0, 'desc']],
                'scrollX' => false,
                'buttons' => [
                    ['extend' => 'reload', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-repeat"></i> Recargar'],
                    [
                        'extend' => 'collection', 'className' => 'btn btn-xs btn-inverse',
                        'text' => '<i class="fa fa-download"></i> Exportar',
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
            '#' => ['name' => 'id', 'data' => 'id'],
            'Usuario' => ['name' => 'people_unlogged.name', 'data' => 'name'],
            'Anónimo' => ['name' => 'people.name', 'data' => 'people', 'visible' => false, 'exportable' => false],
            'Descripción' => ['name' => 'description', 'data' => 'description'],
            'Tipo' => ['name' => 'type', 'data' => 'type'],
            'Generado' => ['name' => 'complaint.created_at', 'data' => 'created_at'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'complaints';
    }
}
