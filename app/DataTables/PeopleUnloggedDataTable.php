<?php

namespace App\DataTables;

use App\Models\PeopleUnlogged;
use Form;
use Yajra\Datatables\Services\DataTable;

class PeopleUnloggedDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            //->addColumn('action', 'people_unloggeds.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $peopleUnloggeds = PeopleUnlogged::query();

        return $this->applyScopes($peopleUnloggeds);
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
                    ],
                    //['extend' => 'colvis', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-eye"></i> Visualizar'],
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
            'Nombre' => ['name' => 'name', 'data' => 'name'],
            'Apellido Paterno' => ['name' => 'last_name_1', 'data' => 'last_name_1'],
            'Apellido Materno' => ['name' => 'last_name_2', 'data' => 'last_name_2'],
            'Teléfono' => ['name' => 'phone_number', 'data' => 'phone_number'],
            'E-mail' => ['name' => 'email', 'data' => 'email']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'peopleUnloggeds';
    }
}
