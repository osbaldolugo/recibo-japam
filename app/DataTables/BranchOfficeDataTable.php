<?php

namespace App\DataTables;

use URL;
use App\Models\BranchOffice;
use Form;
use Yajra\Datatables\Services\DataTable;

class BranchOfficeDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'branch_offices.datatables_actions')
            ->rawColumns(['image', 'action'])
            ->editColumn('image', function ($image) {
                $branchOfficeImage = URL::to('../storage/app/japam/branch_office/'.$image->image);

                return '<img src="'.$branchOfficeImage.'" style="width: 70px; height:50px; margin: 0 auto; border-radius: 5px;">';
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $branchOffices = BranchOffice::query()->orderBy('id', 'DESC');

        return $this->applyScopes($branchOffices);
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
            ->addAction(['width' => '10%', 'title' => 'Acción', 'className' => 'text-center'])
            ->ajax('')
            ->parameters([
                'responsive'=>true,
                'language' =>[
                    'url' =>url('assets/plugins/DataTables/lang/es.json')
                ],
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'buttons' => [
                    ['extend' => 'reload', 'className' => 'btn btn-xs btn-white-without-border', 'text' => '<i class="fa fa-repeat"></i> Recargar'],
                    ['extend' => 'print', 'className' => 'btn btn-xs btn-white-without-border', 'text' => '<i class="fa fa-print"></i> Imprimir'],
                    [
                        'extend'  => 'collection', 'className' => 'btn btn-xs btn-white-without-border',
                        'text'    => '<i class="fa fa-download"></i> Exportar',
                        'buttons' => [
                            'csv',
                            'excel',
                            'pdf',
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
        //, 'render' => '"<img src=\""+data+"\" height=\"50\"/>"'
        return [
            'Sucursal' => ['name' => 'image', 'data' => 'image'],
            'Nombre' => ['name' => 'description', 'data' => 'description'],
            'Calle' => ['name' => 'street', 'data' => 'street'],
            'Número Interior' => ['name' => 'inside_number', 'data' => 'inside_number', 'class' => 'text-center'],
            'Número Exterior' => ['name' => 'outside_number', 'data' => 'outside_number', 'class' => 'text-center'],
            'Colonia' => ['name' => 'settlement', 'data' => 'settlement'],
            'Código Postal' => ['name' => 'cp', 'data' => 'cp', 'class' => 'text-center'],
            //'latitude' => ['name' => 'latitude', 'data' => 'latitude'],
            //'longitude' => ['name' => 'longitude', 'data' => 'longitude'],
            'Teléfono' => ['name' => 'number_phone', 'data' => 'number_phone', 'class' => 'text-center'],
            'Extensiones' => ['name' => 'extension', 'data' => 'extension']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'branchOffices';
    }
}
