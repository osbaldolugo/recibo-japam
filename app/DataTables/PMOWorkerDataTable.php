<?php

namespace App\DataTables;

use App\Models\PMOWorker;
use Form;
use Yajra\Datatables\Services\DataTable;

class PMOWorkerDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'p_m_o_workers.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $speciality = $this->request()->get('speciality');
        $pMOWorkers = PMOWorker::query()->with('pmoSpeciality');
        if (!empty($speciality))
            $pMOWorkers->where('speciality_id', $speciality);
        return $this->applyScopes($pMOWorkers);
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
            'ID_de Nómina' => ['name' => 'nom_id', 'data' => 'nom_id'],
            'Especialidad' => ['name' => 'speciality', 'data' => 'pmo_speciality.speciality', 'searchable' => false],
            'Salario' => ['name' => 'dairy_salary', 'data' => 'dairy_salary'],
            'Nombre' => ['name' => 'name', 'data' => 'name']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pMOWorkers';
    }
}
