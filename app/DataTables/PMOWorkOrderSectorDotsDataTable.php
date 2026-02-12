<?php

namespace App\DataTables;

use App\Models\PMOWorkOrderSectorDots;
use Form;
use Yajra\Datatables\Services\DataTable;

class PMOWorkOrderSectorDotsDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'p_m_o_work_order_sector_dots.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $pMOWorkOrderSectorDots = PMOWorkOrderSectorDots::query();

        return $this->applyScopes($pMOWorkOrderSectorDots);
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
            'lat' => ['name' => 'lat', 'data' => 'lat'],
            'lng' => ['name' => 'lng', 'data' => 'lng']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pMOWorkOrderSectorDots';
    }
}
