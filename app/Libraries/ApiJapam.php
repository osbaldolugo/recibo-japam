<?php

namespace App\Libraries;

use Carbon\Carbon;
use DateTime;
use App\Libraries\HttpConnection;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;


class ApiJapam
{
    private $http;
    private $serverIP;
    private $serveUrl;

    public function __construct()
    {
        $this->http = new HttpConnection();
        //$this->serverIP = "http://45.5.52.110:1022";
        /*$this->serverIP = "http://45.5.52.109:1022";*/
        $this->serverIP = "http://45.5.52.164:7000";
        $this->urlbase = "/sicagua35/api";
        /*$this->API = "/TRecibo/valwcontrato/22560-22560-2064"; //inicio en la logica de la aplicacion;
        $this->API = "/TRecibo/valwcontrato/22560-22560-20642"; //validar el contrato
        $this->API = "/TRecibo/listarecibo/22560"; //lista de recibos
        $this->API = "/TRecibo/m_recibo/14136415"; //main recibo
        //Cumplido : hasta fecha vencimiento
        //Normal : despues de fecha vencimiento
        $this->API = "/TRecibo/d_recibo/14136415"; //detalle recibo
        $this->API = "/TRecibo/getrecibo/14136415"; //Get base 64 recibo
        $this->API = "/TRecibo/getinfcontrato/22560"; //get info contrato
        $this->API = "/TRecibo/listaconvenio/22560"; //lista de convenio
        $this->API = "/TConvenio/listaconvenio/22560";*/

        //$this->serveUrl = $this->serverIP. "/datasnap/rest/TWebAcces/";
        $this->serveUrl = $this->serverIP. $this->urlbase;
    }

    /**
     * Determines if a contract is valid using only one variable
     * @param $contract
     * @return mixed
     * @throws \Exception
     */
    public function validateOnlyContract($contract) {

        $this->http->setCookiePath("/my_cookie_path/");
        $this->http->init();
        $res = $this->http->get($this->serveUrl . "/TRecibo/valwcontrato/" . $contract);
        $response = json_decode($res, true);
        $this->http->close();
        return $response->result;
    }

    /**
     * Determines if a contract is valid using only one variable
     * @param $contract
     * @return mixed
     * @throws \Exception
     */
    public function sendPayment($recId,$monto,$formaPago) {
        /*$this->http->setCookiePath("/my_cookie_path/");
        $this->http->init();
        Log::info($this->serveUrl . "RegistraPago/" . $recId."/".$monto."/".$formaPago);
        $res = $this->http->get($this->serveUrl . "RegistraPago/" . $recId."/".$monto."/".$formaPago);
        $response = json_decode($res);
        $this->http->close();
        return $response->result;*/
    }


    /**
     * Determines if a contract is valid
     *
     * @param $contract
     * @param $barcode
     * @return boolean
     * @throws \Exception
     */
    public function validateContract($contract)
    {

        $this->http->setCookiePath("/my_cookie_path/");
        $this->http->init();
        $res = $this->http->get($this->serveUrl . "/TRecibo/valwcontrato/" . $contract );
        $response = json_decode($res,true);
        $this->http->close();
        return $response;
    }

    /**
     * Determines if a contract is valid
     *
     * @param $contract
     * @param $barcode
     * @return boolean
     * @throws \Exception
     */
    public function agreementContract($contract)
    {
        $explode_contract = explode("-",$contract);
        $this->http->setCookiePath("/my_cookie_path/");
        $this->http->init();
        $res = $this->http->get($this->serveUrl . "/TConvenio/listaconvenio/" . $explode_contract[1] );
        $response = json_decode($res,true);
        $this->http->close();

        return $response;
    }

    /**
     * Returns the general information of a receipt for example (address, owner, amount, etc)
     *
     * @param $contract
     * @param $barcode
     * @return array
     * @throws \Exception
     */
    public function receiptGeneralDetails($contract)
    {

        $explode_contract = explode("-",$contract);

        $this->http->setCookiePath("/my_cookie_path/");
        $this->http->init();
       // Log::info($this->serveUrl . $this->urlbase. "/TRecibo/listarecibo/".$explode_contract[1]);

        $res = $this->http->get($this->serveUrl . "/TRecibo/listarecibo/".$explode_contract[1]);
        //Log::info("omar y fer");
        //Log::info($res);
        $response = json_decode($res,true);
        
      //  Log::info($response);
        $this->http->close();

        foreach($response as $res){
           // Log:info("***");
            //Log::info(Carbon::createFromFormat('!Y/m/d',  "2010/10/05"));
            //Log::info($res["FechaVencimiento"]);
            $numrecibo = $res["NumRecibo"];
            $fechaV = $res["FechaVencimiento"];
            break;
        }

        $res = $this->http->get($this->serveUrl ."/TRecibo/m_recibo/".$numrecibo);
    //    Log::info($res);
        $response = json_decode($res, true);
    //    Log::info($response);
        $this->http->close();
        
        $receipt = array();
        if (!is_null($response))
        {
            /*Version anterior*/
            $receipt = [
                "receiptId" => $response[0]["Recibo"],
                "contract" => $contract,
                "barcode" => $contract,
                "name" => ucwords(strtolower($response[0]["Usuario"])),
                "street" => ucwords(strtolower($response[0]["Calle"])),
                "direccion" => ucwords(strtolower($response[0]["Direccion"])),
                "giro" => ucwords(strtolower($response[0]["Giro"])),
                "tarifa" => ucwords(strtolower($response[0]["Tarifa"])),
                "vencimiento" => ucwords(strtolower($response[0]["Vencimiento"])),
                "status" => ucwords(strtolower($response[0]["StatusPago"])),
                "mesesDeAdeudo" => ucwords(strtolower($response[0]["PagosVencido"])),
                "totalNormal" => ucwords(strtolower($response[0]["Total_Normal"])),
                "totalCumplido" => ucwords(strtolower($response[0]["TotalCumplido"])),
                "urlQrNormal" => isset($response[0]["QR_Normal"])?ucwords($response[0]["QR_Normal"]):'',
                "urlQrCumplido" => isset($response[0]["QR_Cumplido"])?ucwords($response[0]["QR_Cumplido"]):'',
                "clave" => ucwords(strtolower($response[0]["Clave"])),
                "periodo" => ucwords(strtolower($response[0]["Periodo"])),
                "consumo" => ucwords(strtolower($response[0]["Consumo"])),
                "CB_Oxxo" => ucwords(strtolower($response[0]["CB_Oxxo"])),
                /*"outsideNum" => $data->NumExt[0],
                "insideNum" => $data->NumInt[0],
                "bis" => $data->Bis[0],
                "block" => $data->manzana[0],
                "lotNum" => $data->lote[0],*/
                "settlement" => ucwords(strtolower($response[0]["Colonia"])),
                "consumptionPeriod" => ucwords(strtolower($response[0]["Periodo"])),
                "expirationDate" => Carbon::createFromFormat('!Y-m-d',  $fechaV),
                /*"amount" => number_format($data->rec_total[0], 2),*/
                "expiredPeriods" => $response[0]["PagosVencido"],
                "payDate" => isset($response[0]["PagosVencido"]) ? "" : Carbon::createFromFormat('Y-m-d',  $response[0]["Vencimiento"])->format('Y-m-d'),
                "payStatus" => ucwords(strtolower($response[0]["StatusPago"]))
            ];

            if($response[0]["Vencimiento"] == "INMEDIATO"){
                if(isset($response[0]["QR_Normal"]) && isset($response[0]["QR_Cumplido"])) {
                    $receipt["amount"] = number_format(($response[0]["Total_Normal"]), 2, '.', '');
                    $receipt["url_pay"] = $response[0]["QR_Normal"];
                }else{
                    $receipt["amount"]= number_format(($response[0]["Total_Normal"]), 2, '.', '');
                    $receipt["url_pay"]= null ;
                }
            }else{
                if(isset($response[0]["QR_Normal"]) && isset($response[0]["QR_Cumplido"])){
                    if(ucwords(strtolower($response[0]["StatusPago"])) == "No Pagado" && floatval($response[0]["TotalCumplido"]) !== 0 ) {
                        $receipt["amount"] = number_format(($response[0]["Total_Normal"]), 2, '.', '');
                        $receipt["url_pay"] = $response[0]["QR_Normal"];
                    }else{
                        if (Carbon::createFromFormat('Y-m-d', $fechaV)->diffInDays(Carbon::now()) < 0) {
                            $receipt["amount"] = number_format(($response[0]["Total_Normal"]), 2, '.', '');
                            $receipt["url_pay"] = $response[0]["QR_Normal"];
                        } else {
                            $receipt["amount"] = number_format(($response[0]["TotalCumplido"]), 2, '.', '');
                            $receipt["url_pay"] = $response[0]["QR_Cumplido"];
                        }
                    }
                }else{
                    
                    $receipt["amount"]= number_format(0);
                    $receipt["url_pay"]= null;
                }
            }
        }
        //$receipt = $this->receiptAllDetails($receipt);

        return $receipt;
    }


    /**
     * Return the payment details of the receipt
     *
     * @param $recId
     * @param $isExpReceipt
     * @return mixed
     * @throws \Exception
     */
    public function receiptPaymentDetails($recId, $isExpReceipt, $olderAmount)
    {
        $this->http->setCookiePath("/my_cookie_path/");
        $this->http->init();
        $res = $this->http->get($this->serveUrl . "/TRecibo/d_recibo/" . $recId);
        $response = json_decode($res,true);
      //  Log::info($response);
        $this->http->close();

        $payment = array();
        if (!is_null($response))
        {
            $count = count($response);
            $details = array();
            for($i=0;$i<$count;$i++){
                //$subtotal = $isExpReceipt ? $data->dre_importetotal2[$i] : $data->dre_importetotal[$i];
                $subtotal = $response[$i]["Importe"];
                array_push($details, [
                    "id" => $response[$i]["Recibo"],
                    "name" => ucwords(strtolower($response[$i]["Concepto"])),
                    "subtotal" => number_format(strtotime($subtotal), 2)
                ]);
            }

//          $amount = $isExpReceipt ? $data->Total2[0] : $olderAmount;
            /*$amount = $data->Total2[0];
            $amount = str_replace(',', '', $amount);*/

            $payment = [
                /*"headers" =>[
                    "receiptId" => $data->rec_id[0],
                    //"amount" => number_format($amount, 2),
                    "amount" => number_format((float)$amount, 2,'.',''),
                    "isExpiration" => $isExpReceipt,
                    "version" => 4.3580736//4.36
                ],*/
                "details" => $details
            ];
        }

        return $payment;
    }

    /**
     * Generate receipt and return pdf url
     *
     * @param $recId
     * @return string
     * @throws \Exception
     */
    public function generateReceiptPDF($recId)
    {
        $this->http->setCookiePath("/my_cookie_path/");
        $this->http->init();
        $res = $this->http->get($this->serveUrl . "/TRecibo/getRecibo/" . $recId);
        $response = json_decode($res, true);
        $this->http->close();


        return $response;
    }
    /*public function generateReceiptPDF($recId)
    {
        $this->http->setCookiePath("/my_cookie_path/");
        $this->http->init();
        $res = $this->http->get($this->serveUrl . "GetRecPdf/" . $recId);
        $response = json_decode($res);
        $this->http->close();
        $urlReceipt = "";
        if ($response->result[0])
        {
            $urlReceipt = $this->serverIP."/File/ReciboJapam_" . $recId . ".pdf";
        }

        return $urlReceipt;
    }*/


    //DEPRECATED FUNCTION
    public function receiptAllDetails($receipt){

        $this->http->setCookiePath("/my_cookie_path/");
        $this->http->init();
        $url = $this->serveUrl."GetDRecibo/".$receipt["receiptId"]."/";
        $res = $this->http->get($url);
        $response = json_decode($res);
        $this->http->close();

        if(isset($response->result[0]->Total2[0])){
            if ($receipt["amount"] < number_format($response->result[0]->Total2[0], 2)) {
                $receipt["amount"] = number_format($response->result[0]->Total2[0], 2);
            }
        }

        return $receipt;
    }

}