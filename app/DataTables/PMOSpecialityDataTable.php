<?php

namespace App\DataTables;

use App\Models\PMOSpeciality;
use Form;
use Yajra\Datatables\Services\DataTable;

class PMOSpecialityDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('d/F/Y h:i:s a');
            })
            ->addColumn('action', 'p_m_o_specialities.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $pMOSpecialities = PMOSpeciality::query();

        return $this->applyScopes($pMOSpecialities);
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
            'Especialidad' => ['name' => 'speciality', 'data' => 'speciality'],
            'Generado' => ['name' => 'created_at', 'data' => 'created_at'],
//            'deleted_at' => ['name' => 'deleted_at', 'data' => 'deleted_at']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pMOSpecialities';
    }
}
