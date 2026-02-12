<?php

namespace App\DataTables;

use App\Models\PMOMaterial;
use Form;
use Yajra\Datatables\Services\DataTable;

class PMOMaterialDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('price', function ($data) {
                return '<div class="text-right">$ ' . number_format($data->price, 2) . '</div>';
            })
            ->addColumn('action', 'p_m_o_materials.datatables_actions')
            ->rawColumns(['price'])
            ->escapeColumns(['price' => 'price'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $pMOMaterials = PMOMaterial::query();

        return $this->applyScopes($pMOMaterials);
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
            'Código' => ['name' => 'code', 'data' => 'code'],
            'Unidad' => ['name' => 'unit', 'data' => 'unit'],
            'Descripción' => ['name' => 'description', 'data' => 'description'],
            'Precio Unitario' => ['name' => 'price', 'data' => 'price']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pMOMaterials';
    }
}
