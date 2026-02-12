<?php

namespace App\DataTables;

use App\Models\Priority;
use Form;
use Yajra\Datatables\Services\DataTable;

class PriorityDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('color', function($data) {
                return  '<span class="p-5 text-white" style="background-color: ' . $data->color .'">&nbsp;' . $data->color . '</span>';
            })
            ->editColumn('response_time', function ($data) {
                return $data->response_time . ' días.';
            })
            ->addColumn('action', 'priorities.datatables_actions')
            ->rawColumns(['name'])
            ->escapeColumns(['name' => 'name'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $priorities = Priority::query();

        return $this->applyScopes($priorities);
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
                    ['extend' => 'print', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-print"></i> Imprimir'],
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
            'Color (RGB)' => ['name' => 'color', 'data' => 'color'],
            'Tiempo Respuesta' => ['name' => 'response_time', 'data' => 'response_time']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'priorities';
    }
}
