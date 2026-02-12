<?php

namespace App\DataTables;

use URL;
use App\Models\AppSliderHome;
use Form;
use Yajra\Datatables\Services\DataTable;

class AppSliderHomeDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'app_slider_homes.datatables_actions')
            ->rawColumns(['image', 'status', 'action'])
            ->editColumn('image', function ($image) {
                $sliderHomeImage = URL::to('../storage/app/japam/app_slider_home/'.$image->image);

                return '<img src="'.$sliderHomeImage.'" style="width: 70px; height:45px; margin: 0 auto; border-radius: 5px;">';
            })
            ->editColumn('status', function ($status) {
                //$txtStatus = ($status->status == 'enable') ? "<h4><span class='label label-success'>Habilitada</span></h4>" : "<h4><span class='label label-danger'>Deshabilitada</span></h4>";
                $txtStatus = '';
                if ($status->status == 'default')
                    $txtStatus = "<h4><span class='label label-inverse'><i class='fa fa-lock'>&nbsp;</i>Default</span></h4>";

                if ($status->status == 'habilitada')
                    $txtStatus = "<h4><span class='label label-success'><i class='fa fa-check-circle'>&nbsp;</i>Habilitada</span></h4>";

                if ($status->status == 'deshabilitada')
                    $txtStatus = "<h4><span class='label label-danger'><i class='fa fa-times-circle'>&nbsp;</i>Deshabilitada</span></h4>";

                return $txtStatus;
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
        $appSliderHomes = AppSliderHome::query()->orderBy('id', 'DESC');

        return $this->applyScopes($appSliderHomes);
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
            ->addAction(['width' => '15%', 'title' => 'Acción', 'className' => 'text-center'])
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
        return [
            'Imagen' => ['name' => 'image', 'data' => 'image', 'class' => 'text-center'],
            'Estado' => ['name' => 'status', 'data' => 'status', 'class' => 'text-center', 'width' => '50%']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'appSliderHomes';
    }
}
