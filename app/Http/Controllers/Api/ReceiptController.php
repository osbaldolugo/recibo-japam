<?php

namespace App\Http\Controllers\Api;

use DB;
use Log;
use Auth;
use DateTime;
use Carbon\Carbon;
use App\Models\Receipt;
use App\Models\AppUser;
use App\Models\PayControl;
use App\Libraries\ApiJapam;
use App\Models\ReceiptUser;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

class ReceiptController extends AppBaseController
{
    private $apiJapam;

    /**
     * ReceiptController constructor.
     */
    public function __construct()
    {
        $this->apiJapam = new ApiJapam();
    }

    public function index(){
        $receipts = Auth::user()->receipts;
        //$appUser = AppUser::find(1);
        $listReceipt = array();
        foreach ($receipts as $receipt){
            $receiptItem = $this->apiJapam->receiptGeneralDetails($receipt->contract, $receipt->barcode);
            if(count($receiptItem)>0){
                $payControl = PayControl::where('receipt', $receiptItem['receiptId'])->first();
                $receiptItem['payStatus'] = is_null($payControl) ? $receiptItem['payStatus'] : ucwords(strtolower($payControl->pay_status));
                $receiptItem['payDate'] =  is_null($payControl) ? $receiptItem['payDate'] :  Carbon::parse($payControl->pay_date)->format('d-M-Y');

                //$receiptItem['contract']  = $receipt->contract;
                $receiptItem['barcode']  = $receipt->barcode;
                $receiptItem['alias']  = $receipt->alias;
                $receiptItem['id']  = $receipt->id;
                array_push($listReceipt, $receiptItem);
            }
        }

        return response()->json(['receipts' => $listReceipt], 200);
    }

    public function store(Request $request)
    {
        return Receipt::createReceipt($request->all(),Auth::user());
    }

    public function delete($id)
    {
        $receipt = Receipt::find($id);
        $receipt->delete();
        return response()->json(['success' => 1, 'msg' => 'Recibo '.$receipt->contract.' eliminado correctamente.']);
    }
    
    public function getAgreement($contract){

        $agreements = $this->apiJapam->agreementContract($contract);

        foreach($agreements as $a => $agreement){
            $agreement["receipt"] = $this->apiJapam->receiptPaymentDetails($agreement["NumRecibo"]);
        }
        return response()->json(['agreements' => $agreements], 200);
    }

    public function getReceiptAgreements($contract)
    {
        $agreements = $this->apiJapam->agreementContract($contract);
        return response()->json(['agreements' => $agreements], 200);
    }

    //      Esta es la funcion que solicita la informacion del recibo de SICAGUA
    //      No es la que utiliza el searchguest , web consulta de recibos, usa uno que esta dentro de controlers directo igual Http/Controllers/ReceiptController.php
    
    public function getReceiptInformation($contract)
    {
        if(env("MANTENIMIENTO")){
            return response()->json(["errors"=>["contract" => "El sistema se encuentra en mantenimiento."]])->setStatusCode(422);
        }
        
        $isValidContract = $this->apiJapam->validateContract($contract);
        
        //      Checar que contenga un resultado la accion del renglon anterior.
        
        if(isset($isValidContract[0]["valor"])){
            if( $isValidContract[0]["valor"] == "no existe")
            {
                return response()->json(["errors"=>["contract" => "La información ingresada es invalida."]])->setStatusCode(422);
            }
            else
            {
                //  Se declara $receipt como la variable que contiene toda la respuesta
                $receipt = $this->apiJapam->receiptGeneralDetails($contract);
                //Log::info("**aqui**");
                //Log::info(json_encode($receipt));
    
                if(count($receipt)==0)
                {
                    return response()->json(["errors"=>["contract" => "La información ingresada es invalida."]])->setStatusCode(422);
                }
                $payControl = PayControl::where('receipt', $receipt['receiptId'])->first();
                //Log::info(json_encode($payControl));
               
                $receipt['payStatus'] = is_null($payControl) ? $receipt['payStatus'] : ucwords(strtolower($payControl->pay_status));
                $receipt['payDate'] =  is_null($payControl) ? $receipt['payDate'] :  Carbon::parse($payControl->pay_date)->format('d-M-Y');
    
                $expirationDate = strtotime($receipt["expirationDate"]);
    
                $receipt["payStatus"] = $receipt["amount"] == '0.00' ? 'Pagado' : $receipt["payStatus"];
                //Determinamos si el usuario pago antes o despues de la fecha de vencimiento
                if($receipt['payStatus'] == 'Pagado'){
                   $payDate = strtotime($receipt['payDate']);
                   $isExpReceipt = empty($receipt['payDate']) ? false : ($payDate > $expirationDate);
                   $receipt['payDate'] = empty($receipt['payDate']) ? 'No Registrada' : $receipt['payDate'];
                }else{
                    $nowDate = strtotime(Carbon::now()->format('Y-m-d'));
                    $isExpReceipt = ($nowDate > $expirationDate);
                }
    
                $payment = $this->apiJapam->receiptPaymentDetails($receipt["receiptId"], $isExpReceipt, $receipt["amount"]);
                //Log::info($payment);
    
                $agreements = $this->apiJapam->agreementContract($contract);
                
    
                return response()->json(['receipt' => $receipt, 'payment'=>$payment, 'agreements' => $agreements], 200);
            }
        }else{
            return response()->json(["errors"=>["contract" => "La información ingresada es invalida."]])->setStatusCode(422);
        }
    }

   /**
    * Generate receipts PDF by receiptId
    */
   public function generateReceiptPDF($receiptId)
    {
        try {
            $apiJapam = new ApiJapam();
            $dataPdf = $apiJapam->generateReceiptPDF($receiptId);
            return response()->json($dataPdf, 200);
        }catch(Exception $e) {
            return response()->json(['error' => "No fue posible obtener el recibo"], 500);
        }
    }

   public function changeAlias(Request $request)
   {
        $data = $request->all();
        $receipt = Receipt::find($data['id']);
        $receipt->alias = $data['alias'];
        $receipt->save();
        return response()->json(['success' => 1, 'msg' => 'Alias asignado correctamente.']);
   }

}
