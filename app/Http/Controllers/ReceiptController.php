<?php

namespace App\Http\Controllers;

use App\Models\AppSettings;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Receipt;
use App\Models\AppUser;
use App\Models\PayControl;
use App\Libraries\ApiJapam;
use App\Models\AppUserCard;
use Illuminate\Http\Request;
use App\Libraries\ApiSrPago;
use App\DataTables\ReceiptDataTable;
use Illuminate\Database\QueryException;
use App\Http\Requests\CreateReceiptRequest;
use Illuminate\Support\Facades\Log;

class ReceiptController extends Controller
{

    public function index(ReceiptDataTable $receiptDataTable)
    {
        return $receiptDataTable->render('user_panel.receipts.index');
    }

    public function store(CreateReceiptRequest $request)
    {
        return Receipt::createReceipt($request->all(), Auth::guard('appuser')->user());
    }

    public function editAlias($id, Request $request)
    {

        $receipt = Receipt::find($id);
        if (empty($receipt))
            return response()->json(["message" => "Recibo no encontrado"], 404);

        $receipt->alias = $request["alias"];
        $receipt->save();

        return response()->json(["message" => "Alias actualizado correctamente"], 200);
    }

    public function viewPays($id)
    {
        $receipt = Receipt::find($id);
        if (empty($receipt))
            return response()->json(["message" => "Recibo no encontrado"], 404);


    }

    public function searchGuest()
    {

        $openPeriod = Carbon::now()->lte(Carbon::now()->day(25));

        $openPeriod = true;


        return view('user_panel.receipts.searchGuest')
            ->with('openPeriod', $openPeriod);
    }


    public function consult(Request $request)
    {
        $receipt = $request->all();

        $receipt["contract"] = $receipt["contract"]. "-".$receipt["contract2"]."-".$receipt["contract3"];

        $apiJapam = new ApiJapam();

        $validate = $apiJapam->validateContract($receipt["contract"]);
        //Log::info($validate);


        if (empty($validate)){
            return response()->json(["errors" => ["contract" => "La información ingresada es invalida."]])->setStatusCode(422);
        }
        $receipt["barcode"] = "";
        //  La siguiente linea es la que hace la consulta que trae la info para consulv2.js , es lo que se consume en web cuando se conluta un contrato.
        //  receiptGeneralDetails  es la funcion que hace dicha llamada, esta funcion esta dentor de :
        $details = $apiJapam->receiptGeneralDetails($receipt["contract"]);
        
        
        Log::info($details);
        //Log::info("---->");
         
        if($details["amount"] == null){
            return response()->json(array("error"=>"El contrato tiene un adeudo, por lo que no permite realizar el pago por el momento (favor de ir a los centros de atención de JAPAM)"));
        }

        //$receiptUrl = $apiJapam->generateReceiptPDF($details["receiptId"]);
        $isPaid = PayControl::where('receipt', $details["receiptId"])->where('pay_status', 'pagado')->first();


        $details['payStatus'] = is_null($isPaid) ? $details['payStatus'] : ucwords(strtolower($isPaid->pay_status));
        $details['payDate'] =  is_null($isPaid) ? $details['payDate'] :  Carbon::parse($isPaid->pay_date)->format('d-M-Y');

        $expirationDate = strtotime($details["expirationDate"]);

        $details["payStatus"] = $details["amount"] == '0.00' ? 'Pagado' : $details["payStatus"];

        //To know if an user payed a receipt before expiration date
        if($details['payStatus'] == 'Pagado'){
            $payDate = strtotime($details['payDate']);
            $isExpReceipt = empty($details['payDate']) ? false : ($payDate > $expirationDate);
            $details['payDate'] = empty($details['payDate']) ? 'No Registrada' : $details['payDate'];
        }else{
            $nowDate = strtotime(Carbon::now()->format('Y-m-d'));
            $isExpReceipt = ($nowDate > $expirationDate);
        }

        $payment = $apiJapam->receiptPaymentDetails($details["receiptId"], $isExpReceipt,  $details["amount"]);

        $details["isExp"] = $isExpReceipt == false ? 0 : 1;


        /*$board = $payment["headers"]["version"] / 100;
        $payment["headers"]["board"] = round($payment["headers"]["amount"] * $board, 2);//4.3580736
        $payment["headers"]["total"] = round($payment["headers"]["amount"] , 2);*/


        $payment["isPaid"] = $details['payStatus'] == 'Pagado';
        $payment["urlPay"] = $details['url_pay'];

        //Split name for metadata
        $name = trim(str_replace('.', '', $details['name']));
        $nameSplit = explode(" ", $name);
        $count_blank = count($nameSplit);
        $firstname = "";
        if($count_blank > 3){
            $lastname = $nameSplit[0]. " " .$nameSplit[1];
            for ($i = 2; $i> $count_blank; $i++){
                if($i == $count_blank){
                    $firstname .= $nameSplit[$i];
                }else{
                    $firstname .= $nameSplit[$i]. " ";
                }
            }
        }elseif($count_blank == 3){
            $lastname = $nameSplit[0]. " " .$nameSplit[1];
            $firstname = $nameSplit[2];
        }elseif($count_blank == 2 ){
            $lastname = $nameSplit[0];
            $firstname = $nameSplit[1];
        }elseif ($count_blank < 2){
            for ($i = 0; $i> $count_blank; $i++){
                $firstname .= $nameSplit[$i];
            }
        }


        $details['firstname'] = $firstname;
        $details['lastname'] = $lastname;

        return response()->json(array(
            //"receiptUrl" => $receiptUrl,
            "receiptId" => $details["receiptId"],
            "receiptContract" => $details["contract"],
            "receiptBarcode" => $details["barcode"],
            "receiptSettlement" => $details["settlement"],
            "receiptName" => $details["name"],
            "direccion" => $details["direccion"],
            "giro" => $details["giro"],
            "tarifa" => $details["tarifa"],
            "vencimiento" => $details["vencimiento"],
            "status" => $details["status"],
            "mesesDeAdeudo" => $details["mesesDeAdeudo"],
            "totalNormal" => $details["totalNormal"],
            "totalCumplido" => $details["totalCumplido"],
            "clave" => $details["clave"],
            "periodo" => $details["periodo"],
            "consumo" => $details["consumo"],
            "cb_oxxo"=>$details["CB_Oxxo"],
            "urlQrNormal" => $details["urlQrNormal"],
            "urlQrCumplido" => $details["urlQrCumplido"],
            "firstname" => $details["firstname"],
            "lastname" => $details["lastname"],

            /*"receiptInsideNum" => $details["insideNum"],
            "receiptOutsideNum" => $details["outsideNum"],*/
            "receiptStreet" => "",$details["street"],
            "receiptAmount" => $details["amount"],
            "receiptPayStatus" => $details["payStatus"],
            "receiptConsumptionPeriod" => $details["consumptionPeriod"],
            "receiptIsExp" => $isExpReceipt,
            "receiptExpiredPeriods" => $details["expiredPeriods"],
            "payment" => $payment
        ));

    }

    public function pay($id)
    {
        $receipt = Receipt::find($id);

        //Get Receipt information from Japam
        $apiJapam = new ApiJapam();
        $details = $apiJapam->receiptGeneralDetails($receipt->contract);
        $isPaid = PayControl::where('receipt', $details["receiptId"])->where('pay_status', 'pagado')->first();


        $details['payStatus'] = is_null($isPaid) ? $details['payStatus'] : ucwords(strtolower($isPaid->pay_status));
        $details['payDate'] =  is_null($isPaid) ? $details['payDate'] :  Carbon::parse($isPaid->pay_date)->format('d-M-Y');

        $expirationDate = strtotime($details["expirationDate"]);

        $details["payStatus"] = $details["amount"] == '0.00' ? 'Pagado' : $details["payStatus"];

        //To know if an user payed a receipt before expiration date
        if($details['payStatus'] == 'Pagado'){
            $payDate = strtotime($details['payDate']);
            $isExpReceipt = empty($details['payDate']) ? false : ($payDate > $expirationDate);
            $details['payDate'] = empty($details['payDate']) ? 'No Registrada' : $details['payDate'];
        }else{
            $nowDate = strtotime(Carbon::now()->format('Y-m-d'));
            $isExpReceipt = ($nowDate > $expirationDate);
        }

        $payment = $apiJapam->receiptPaymentDetails($details["receiptId"], $isExpReceipt,  $details["amount"]);

        $details["isExp"] = $isExpReceipt == false ? 0 : 1;

        //Get default Card
        $card = AppUserCard::where('app_user_id', Auth::guard('appuser')->user()->id)->where("default", 1)->first();

        $board = $payment["headers"]["version"] / 100;
        $payment["headers"]["board"] = round($payment["headers"]["amount"] * $board, 2);//4.3580736
        $payment["headers"]["total"] = round($payment["headers"]["amount"] + $payment["headers"]["board"], 2);

        $openPeriod = Carbon::now()->lte(Carbon::now()->day(25));

        //Split name for metadata
        $name = trim(str_replace('.', '', $details['name']));
        $nameSplit = explode(" ", $name);
        $lastname = $nameSplit[count($nameSplit)-2];

        $details['firstname'] = $nameSplit[0];
        $details['lastname'] = $lastname;


        return view('user_panel.receipts.pay')
            ->with('receipt', $receipt)
            ->with('card', $card)
            ->with('isPaid', $isPaid)
            ->with('openPeriod', $openPeriod)
            ->with('receiptPayment', $payment)
            ->with('receiptDetail', $details);
    }

    public function processPay($type, Request $request)
    {

        if ($request->amount >= 3000){
            return response()->json(["error" => "El monto máximo para realizar el pago a través de la web es de $3,000 pesos."], 400);
        }

        $status = AppSettings::where('id', '=', 1)->first();
        if ($status->pay_control == 'off')
            return response()->json(["message" => "Por el momento no es posible realizar pagos, inténtelo más tarde."], 400);

        $userId = Auth::guard('appuser')->user() ? Auth::guard('appuser')->user()->id : null;
        $isPaid = PayControl::where('receipt', $request["receipt_number"])->first();

        if (!empty($isPaid) && $isPaid->pay_status == 'pagado')
            return response()->json(["message" => "Este recibo ya tiene un pago registrado"], 400);


        $apiSrPago = new ApiSrPago();
        $srPagoTransact = $type == 'card' ? $apiSrPago->cardPayment($request->all()) : $apiSrPago->convenienceStore($request->all());
       // Log::info($srPagoTransact);
        //return response()->json(["message" => $srPagoTransact], 400);



        if($type == 'card'){
            $srPagoTransact['email'] = $request['email'];
            PayControl::sendReceiptPay($srPagoTransact);
        }

        //print_r($srPagoTransact);
        /*if (!isset($srPagoTransact["transaction"]))
            return response()->json(["message" => "Ocurrió un error al procesar el pago," . $srPagoTransact->original["error"]], 400);*/


        try {
            DB::beginTransaction();

            //Save credit card
            if ($request["remember_card"] && $userId) {
                AppUserCard::firstOrCreate([
                    'app_user_id' => $userId,
                    'owner' => $request["owner"],
                    'number' => $request["number"],
                    'exp_month' => $request["exp_month"],
                    'exp_year' => $request["exp_year"]
                ]);
            }

            //Save pay control
            $pay = PayControl::updateOrCreate([
                'receipt' => $request["receipt_number"],
            ],
                [
                    'pay_date' => Carbon::now()->toDateTimeString(),
                    'contract' => $request["contract"],
                    'barcode' => $request["barcode"],
                    'description' => $request["description"],
                    'consumptionPeriod' => $request["consumptionPeriod"],
                    'isExpiration' => $request["isExpiration"],
                    'subtotal' => $request["subtotal"],
                    'platform' => 'web',
                    'total' => $request["amount"],
                    'pay_method' => $type == 'card' ? 'TARJETA': $request['store'],
                    'pay_status' => $type == 'card' ? 'pagado' : 'pendiente'
                ]);

            /*
            if ($type == 'store')
                PayControl::sendMailInstructionsPaymentStores($request, $srPagoTransact);
            */
            $message = $type == 'store' ? 'Referencia de pago generada correctamente, revise las instrucciones en su correo electrónico' : "Pago procesado correctamente";



            $apiJapam = new ApiJapam();
            $reponse = $apiJapam->sendPayment($request["receipt_number"],$request["subtotal"],"99");
          //  Log::info($reponse);

            $route = auth('appuser')->check() ? 'receipts.indexWeb' : 'receipts.searchGuest'; //Auth::guard('appuser')->check()

            return response()->json(["transact" => $srPagoTransact, "message" => $message, "type" => $type, "redirect" => url(route($route))], 200);
        } catch (QueryException $e) {

            DB::rollBack();
            return response()->json(["message" => "Ocurrio un error al procesar el pago, intente más tarde" . $e->getMessage()], 500);

        } catch (\Exception $e) {
            return response()->json(["message" => "Ocurrio un error al procesar el pago, intente más tarde" . $e->getMessage()], 500);
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
    public function bienvenida(){
        return view('Bienvenido');
    }
    
    public function deleteid($id){
        try{
            $delete = Receipt::findOrFail($id);
            //dd($delete);
            $delete->delete();
            return redirect()->route('receipts.indexWeb')->with(array('message', 'Recibo eliminado exitosamente'));
        }catch (Exception $ex) {
            DB::rollback();
            return redirect()->route('receipts.indexWeb')->with(array('message', 'No se eliminó correctamente el recibo'));
        }
    }
}