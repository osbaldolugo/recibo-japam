<?php

namespace App\DataTables;

use App\Models\PMOWorkOrderSuburbs;
use Form;
use Yajra\Datatables\Services\DataTable;

class PMOWorkOrderSuburbsDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'p_m_o_work_order_suburbs.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $pMOWorkOrderSuburbs = PMOWorkOrderSuburbs::query();

        return $this->applyScopes($pMOWorkOrderSuburbs);
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
            'pmo_work_table_id' => ['name' => 'pmo_work_table_id', 'data' => 'pmo_work_table_id'],
            'suburb_id' => ['name' => 'suburb_id', 'data' => 'suburb_id'],
            'created_at' => ['name' => 'created_at', 'data' => 'created_at'],
            'updated_at' => ['name' => 'updated_at', 'data' => 'updated_at']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pMOWorkOrderSuburbs';
    }
}
