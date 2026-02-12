<?php

/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 01:22 PM
 */

namespace App\DataTables;


use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Receipt;
use App\Models\PayControl;
use App\Libraries\ApiJapam;
use Yajra\Datatables\Services\DataTable;

class ReceiptDataTable extends DataTable
{
    private $payStatus;
    private $payDate;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->rawColumns(['alias','contract', 'owner', 'status', 'action'])
            ->editColumn('contract', function ($data) {
                return '<b style="font-size: 1.5rem;">'.$data->contract.'</b>';//'<span class="m-t-20 badge badge-primary" style="font-size:12px;vertical-align:middle;">' . $data->contract . '</span>';
            })
            ->editColumn('alias', function ($data) {
                return '<b style="font-size: 1.5rem; text-transform: uppercase">'.$data->alias.'</b>';//'<span class="m-t-20 badge badge-primary" style="font-size:12px;vertical-align:middle;">' . $data->alias . '</span>';
            })
            ->editColumn('owner', function ($data) {

                $apiJapam = new ApiJapam();
                $details = $apiJapam->receiptGeneralDetails($data->contract,$data->barcode);

                $payControl = PayControl::where('receipt', $details['receiptId'])->first();
                $this->payStatus = is_null($payControl) ? $details['payStatus'] : ucwords(strtolower($payControl->pay_status));
                $this->payDate=  is_null($payControl) ? $details['payDate'] :  Carbon::parse($payControl->pay_date)->format('d-M-Y');

                //To know if an user payed a receipt before expiration date
                if(isset($details["expirationDate"])){
                    $expirationDate = strtotime($details["expirationDate"]);
                    if ($details['payStatus'] == 'Pagado') {
                        $payDate = strtotime($details["payDate"]);
                        $isExpReceipt = ($payDate > $expirationDate);
                    } else {
                        $nowDate = strtotime(Carbon::now()->format('Y-m-d'));
                        $isExpReceipt = ($nowDate > $expirationDate);
                    }
                }



                $urlIcon = url('assets/img/receipt/icon.png');
                $name = empty($details["name"]) ? '' : $details["name"];
                $street = empty($details["street"]) ? '' : $details["street"];
                $outsideNum = empty($details["outsideNum"]) ? '' : $details["outsideNum"];
                $insideNum = empty($details["insideNum"]) ? '' : $details["insideNum"];
                $bis = empty($details["bis"]) ? '' : $details["bis"];
                $settlement = empty($details["settlement"]) ? '' : $details["settlement"];

                return <<<HTML

            <div class="media media-sm">
                <a class="media-left" href="javascript:;">
                    <img src="{$urlIcon}" alt="" class="media-object rounded-corner" style="max-height:65px; box-shadow: 2px 2px 2px #000;">
                </a>
                <div class="media-body">
                    <h4 class="media-heading m-t-5">{$name}</h4>
                    <p>
                        {$street} {$outsideNum} {$insideNum} {$bis} 
                        {$settlement} , San Juan del Río, Qro
                    </p>
                </div>
            </div>
                        
                
HTML;

                //print_r($details);
            })
            ->editColumn('status', function ($data) {
                $class = $this->payStatus != "Pagado"?  "badge-danger": "badge-success";
                $payDate = $this->payDate ? '('.$this->payDate.')' : '';
                return '<span class="m-t-20 badge '. $class .' " style="font-size:12px;vertical-align:middle;">' . $this->payStatus .' '.$payDate. '</span>';
                //dd(, $this->payDate);
            })
            ->editColumn('action', function($data){
                                $route = route('receipts.pay', $data->id);
                $routeDeleteReceipt = route('delete.receipts', $data->id);
                $routaPago = route('receipts.searchGuest');

                $apiJapam = new ApiJapam();
                $details = $apiJapam->receiptGeneralDetails($data->contract);
                $name = empty($details["name"]) ? '' : $details["name"];
                $contract = empty($details["contract"]) ? '' : $details["contract"];
                $periodo = empty($details["periodo"]) ? '' : $details["periodo"];
                $consumo = empty($details["consumo"]) ? '' : $details["consumo"];

                $direccion = empty($details["direccion"]) ? '' : $details["direccion"];
                $settlement = empty($details["settlement"]) ? '' : $details["settlement"];


                $payButton = <<<HTML
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#create{$data->id}">
                   <i class="fa fa-eye"></i> Ver info
                </a>
                <div class="modal fade" id="create{$data->id}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>×</span>
                                </button>
                                <h4>Información del recibo</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <table class="table table-hover" id="tbShow">
                                        <tbody>
                                            <tr>
                                                <th style="text-align: center">Nombre del titular</th>
                                                <td style="text-align: center">{$name}</td>
                                            </tr>
                                            <tr>
                                                <th>Dirección </th>
                                                <td>{$direccion}, {$settlement}, San Juan del Río Qro.</td>
                                            </tr>
                                            <tr>
                                                <th>N° Contrato </th>
                                                <td>{$contract}</td>
                                            </tr>
                                            <tr>
                                                <th>Periodo </th>
                                                <td>{$periodo}</td>
                                            </tr>
                                            <tr>
                                                <th>Consumo </th>
                                                <td>{$consumo}m<sup>3</sup></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="javascript:;" class="btn btn-sm btn-inverse" data-dismiss="modal">Aceptar</a>
                            </div>
                        </div>
                    </div>
                </div>   
HTML;
                $eliminarRecibo = <<<HTML
                <a id="eliminarRecibo" href="{$routeDeleteReceipt}" onclick="return confirm('¿Estas seguro de eliminar el recibo?')" class='btn btn-danger' data-receipt="{$data->id}">
                    <i class="fa fa-times-circle-o"></i> Eliminar Recibo
                </a>
HTML;
                $changeAlias = <<<HTML
                    <a href="#" class='btn btn-inverse' id="changeAlias" data-receipt="{$data->id}">
                        <i class="fa fa-user"></i> Cambiar Alias
                    </a>
HTML;
                $delete = $eliminarRecibo;
                $buttons = $this->payStatus != 'Pagado' ? $payButton .$changeAlias. $eliminarRecibo : $payButton. $changeAlias. $eliminarRecibo;

                return <<<HTML
                <div class='btn-group btn-group-xs btn-group-vertical'>
                    {$buttons}
                </div>
HTML;
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

        $receipts = Receipt::select(['receipt.id', "contract", 'alias', DB::raw('"" as owner')])
            ->join('receipt_user', 'receipt_id', '=', 'receipt.id')
            ->where('app_user_id', Auth::guard('appuser')->user()->id);


        return $this->applyScopes($receipts);
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
            ->addAction(['width' => '20%', 'class' => "text-center"])
            ->ajax('')
            ->parameters([
                'language' => ['url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'],
                'dom' => 'Bfrtip',
                'order' => [[0, 'desc']],
                'pageLength' => 5,
                'responsive' => true,
                'serverSide' => true,
                'scrollX' => false,
                'buttons' => [
                    ["extend" => "reload", "text" => "<i class='fa fa-refresh'></i> Recargar"]
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
            'Titular' => ['name' => 'alias', 'data' => 'owner', 'searchable' => false, 'width' => '30%'],
            'Alias' => ['name' => 'alias', 'data' => 'alias', 'class' => "text-center"],
            'Nº_contrato' => ['name' => 'contract', 'data' => 'contract', 'class' => "text-center"],
            'Status' => ['name' => 'status', 'data' => 'status', 'class' => "text-center"],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'recibos';
    }
}