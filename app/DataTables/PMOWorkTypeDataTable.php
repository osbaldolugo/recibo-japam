<?php

namespace App\DataTables;

use App\Models\PMOWorkType;
use Form;
use Yajra\Datatables\Services\DataTable;

class PMOWorkTypeDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'p_m_o_work_types.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $pMOWorkTypes = PMOWorkType::query();

        return $this->applyScopes($pMOWorkTypes);
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
                'responsive' => true,
                'buttons' => [
                    ['extend' => 'reload', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-repeat"></i> Recargar'],
                    [
                        'extend'  => 'collection', 'className' => 'btn btn-xs btn-inverse',
                        'text'    => '<i class="fa fa-download"></i> Exportar',
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
            'Tipo' => ['name' => 'type', 'data' => 'type'],
            'Código' => ['name' => 'code', 'data' => 'code'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pMOWorkTypes';
    }
}
