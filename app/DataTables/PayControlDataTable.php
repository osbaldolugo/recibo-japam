<?php

namespace App\DataTables;

use DB;
use App\Models\PayControl;
use Yajra\Datatables\Services\DataTable;

class PayControlDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->rawColumns(['isExpiration','platform'])
            //->addColumn('action', 'paycontrol.datatables_actions')
            ->editColumn('isExpiration', function ($pay) {
                $img = $pay->isExpiration ?'sad.png' :  'happy.png' ;
                return '<span class="user-image">
                        <img src="' .  url('img/'.$img) . '" alt="Usuario Cumplido" style="width: 22px; height: 22px;" />
                    </span>';
            })
            ->editColumn('platform', function ($pay) {
                $img = $pay->platform.'.png';
                return '<span class="user-image">
                        <img src="' .  url('img/'.$img) . '" alt="'.$pay->platform.'" style="width: 22px; height: 22px;" />
                    </span>';
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
        $begin = $this->request()->get('begin');
        $end = $this->request()->get('end');
        $pay_method = $this->request()->get('pay_method');

        $payControl = PayControl::query();

         if (!empty($begin) && !empty($end)) {
             $payControl->whereBetween('pay_control.pay_date', [$begin, $end]);
         }
         if (!empty($pay_method))
            $payControl->where('pay_method', $pay_method);
        return $this->applyScopes($payControl);
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
           // ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'pageLength'=> 25,
                'responsive'=>true,
                'language' =>[
                    'url' =>url('assets/plugins/DataTables/lang/es.json')
                ],
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
                            'excel',
                            //'pdf',
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
            'isExpiration' => ['name' => 'isExpiration', 'data' => 'isExpiration', 'title'=>'Usuario Cumplido', 'width'=>'5%'],
            'Recibo' => ['name' => 'receipt', 'data' => 'receipt'],
            'Descripcion' => ['name' => 'description', 'data' => 'description'],
            'Fecha_de_Pago' => ['name' => 'pay_date', 'data' => 'pay_date'],
            'Metodo_de_Pago' => ['name' => 'pay_method', 'data' => 'pay_method'],
            'Subtotal' => ['name' => 'subtotal', 'data' => 'subtotal'],
            'Total' => ['name' => 'total', 'data' => 'total'],
            'Status' => ['name' => 'pay_status', 'data' => 'pay_status'],
            'platform' => ['name' => 'platform', 'data' => 'platform', 'title'=>'Plataforma']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'appUsers';
    }
}
