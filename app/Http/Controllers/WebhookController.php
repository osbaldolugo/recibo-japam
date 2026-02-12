<?php

namespace App\Http\Controllers;

use App\Libraries\ApiJapam;
use App\Libraries\WebPayPLUS\AESCrypto;
use App\Models\PayControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController  extends Controller
{

     public function handlePaymentSucceeded(Request $request)
    {

        Log::info("WEBHOOK -----------------");
        $operation = $request->input('operation');
        Log::info($request->all());
        Log::info($operation);
        $payControl = PayControl::where('receipt', $operation['reference']['number'])->first();

        if($payControl){
            $payControl->pay_status = 'pagado';
            $payControl->save();

            $apiJapam = new ApiJapam();
            $reponse = $apiJapam->sendPayment($request["receipt_number"],$request["subtotal"],"31");
            Log::info($reponse);

            //PayControl::sendReceiptPay($operation['email'], $operation['clientName']);

            return response()->json(['msg' => 'Pago realizado correctamente.'], 200);
        }
    }
    
    public function getPaymentInfo(Request $request){
        Log::info("WEBHOOK __________");
        $webPay = new AESCrypto();
        $originalString = (String)$request->input("strResponse");
        $decodedString =  (String) urldecode( $originalString );
        $key = '5dcc67393750523cd165f17e1efadd21'; //Llave de 128 bits
        $decryptedString = $webPay->desencriptar($decodedString, $key);

        $xml_load = simplexml_load_string($decryptedString);
        $xml["response"] = $xml_load->xpath('/CENTEROFPAYMENTS/response');
        $xml["reference"] = $xml_load->xpath('/CENTEROFPAYMENTS/reference');
        $xml["foliocpagos"] = $xml_load->xpath('/CENTEROFPAYMENTS/foliocpagos');
        $xml["cd_response"] = $xml_load->xpath('/CENTEROFPAYMENTS/cd_response');
        $xml["cd_error"] = $xml_load->xpath('/CENTEROFPAYMENTS/cd_error');
        $xml["time"] = $xml_load->xpath('/CENTEROFPAYMENTS/time');
        $xml["date"] = $xml_load->xpath('/CENTEROFPAYMENTS/date');
        $xml["nb_company"] = $xml_load->xpath('/CENTEROFPAYMENTS/nb_company');
        $xml["nb_merchant"] = $xml_load->xpath('/CENTEROFPAYMENTS/nb_merchant');
        $xml["cc_type"] = $xml_load->xpath('/CENTEROFPAYMENTS/cc_type');
        $xml["tp_operation"] = $xml_load->xpath('/CENTEROFPAYMENTS/tp_operation');
        $xml["cc_name"] = $xml_load->xpath('/CENTEROFPAYMENTS/cc_name');
        $xml["cc_number"] = $xml_load->xpath('/CENTEROFPAYMENTS/cc_number');
        $xml["amount"] = $xml_load->xpath('/CENTEROFPAYMENTS/amount');
        $xml["id_url"] = $xml_load->xpath('/CENTEROFPAYMENTS/id_url');
        $xml["email"] = $xml_load->xpath('/CENTEROFPAYMENTS/email');
        $xml["datos_adicionales"] = $xml_load->xpath('/CENTEROFPAYMENTS/datos_adicionales');


        $xml_auth = $xml_load->xpath('/CENTEROFPAYMENTS/auth');
        $xml_url = $xml_load->xpath('/CENTEROFPAYMENTS/nb_url');

        Log::info("Decrypted ___".$decryptedString);

        return response()->json(array("decryptedString" => $xml));


    }
}