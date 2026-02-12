<?php

namespace App\DataTables;

use App\Models\PMOWorkTableFinish;
use Form;
use Yajra\Datatables\Services\DataTable;

class PMOWorkTableFinishDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'p_m_o_work_table_finishes.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $pMOWorkTableFinishes = PMOWorkTableFinish::query();

        return $this->applyScopes($pMOWorkTableFinishes);
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
            'work_time' => ['name' => 'work_time', 'data' => 'work_time'],
            'cause_id' => ['name' => 'cause_id', 'data' => 'cause_id'],
            'supervisory_id' => ['name' => 'supervisory_id', 'data' => 'supervisory_id'],
            'captured_id' => ['name' => 'captured_id', 'data' => 'captured_id'],
            'tools_cost' => ['name' => 'tools_cost', 'data' => 'tools_cost'],
            'other_cost' => ['name' => 'other_cost', 'data' => 'other_cost']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pMOWorkTableFinishes';
    }
}
