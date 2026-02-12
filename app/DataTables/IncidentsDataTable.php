<?php

namespace App\DataTables;

use App\Models\Incidents;
use Form;
use Yajra\Datatables\Services\DataTable;

class IncidentsDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->format('d/F/Y h:i:s a');
            })
            ->addColumn('action', 'incidents.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $incidents = Incidents::query();

        return $this->applyScopes($incidents);
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
                'dom' => 'Bfrtip',
                'language' => ['url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'],
                'scrollX' => false,
                'buttons' => [
                    ['extend' => 'reload', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-repeat"></i> Recargar'],
                    [
                         'extend'  => 'collection', 'className' => 'btn btn-xs btn-inverse',
                         'text'    => '<i class="fa fa-download"></i> Exportar',
                         'buttons' => [
                             'csv',
                             'excel'
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
            'Nombre' => ['name' => 'name', 'data' => 'name'],
            'Descripción' => ['name' => 'description', 'data' => 'description'],
            'Última Actualización' => ['name' => 'updated_at', 'data' => 'updated_at'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'incidents';
    }
}
