<?php

namespace App\Http\Controllers\Api;

use App\Models\AppSettings;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\PayControl;
use App\Libraries\ApiSrPago;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

class PayController extends AppBaseController
{
    private $apiSrPago;

    public function __construct()
    {
        if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
            $this->middleware('auth:api');
        }
        $this->apiSrPago = new ApiSrPago();
    }

    /*
    * Generate pay with card
    */
    public function generatePayWithCard(Request $request)
    {
        if ($request->amount >= 3000){
            return response()->json(["error" => "El monto máximo para realizar el pago a través de la app es de $3,000 pesos."], 400);
        }

        $status = AppSettings::where('id', '=', 1)->first();

        if ($status->pay_control == 'off')
            return response()->json(["error" => "Lo sentimos, por el momento los servidores se encuentran en mantenimiento."], 400);
            //return response()->json(["error" => "Lo sentimos por cierre de mes ya no se pueden recibir más pagos."], 400);

        /*
        $endDate = '2018-03-31 12:00:00';
        $now = Carbon::now()->toDateTimeString();

        if(strtotime($now) >= strtotime($endDate)){
            return response()->json(['error' => 'Lo sentimos por cierre de mes ya no se pueden recibir más pagos.'], 400);
        }
        */

        if(empty($request->app_version)){
            return response()->json(['error' => 'Actualiza tu aplicación Japam Móvil para poder realizar tu pago.'], 400);
        }
        $request['ip'] = $request->getClientIp();
        try
        {
            DB::beginTransaction();

            $payControl = PayControl::updateOrCreate(
                [ 'receipt' => $request['reference'] ],
                [
                    'app_user_id' => Auth::check() ? Auth::user()->id : null,
                    'receipt' => $request['reference'],

                    'barcode' => $request['barcode'],
                    'contract' => $request['contract'],
                    'consumptionPeriod' => $request['consumptionPeriod'],
                    'isExpiration' => $request['isExpiration'],

                    'description' => $request['description'],
                    'pay_date' => Carbon::now(),
                    'pay_method' => 'TARJETA',
                    'subtotal' => $request['subtotal'],
                    'total' => $request['amount'],
                    'platform' => is_null($request['platform']) ? 'android': $request['platform'],//'app'
                    'pay_status' => 'pendiente',
                    'app_version'=> $request['app_version']
                ]);


            $cardPayment = $this->apiSrPago->cardPayment($request);

            DB::commit();
            if ($cardPayment['reference']['number'] == $request['reference']) {
                $payControl->pay_status = 'pagado';
                $payControl->save();

                $cardPayment['email'] = $request['email'];
                PayControl::sendReceiptPay($cardPayment);

                return response()->json(['msg' => 'Pago realizado correctamente.'], 200);
            } else {
                return response()->json(['error' => 'Pago no realizado. Intentar más tarde.'], 422);
            }
        } catch (\Exeption $e)
        {
            DB::rollback();
            return response()->json(['error' => 'Ocurrió un error al realizar el pago.'], 422);
        }
    }


    /*
     * Generate a reference to the convenience store
     */
    public function generateReferenceStore(Request $request){
        if ($request->amount >= 3000){
            return response()->json(["error" => "El monto máximo para realizar el pago a través de la app es de $3,000 pesos."], 400);
        }

        if(empty($request->contract)){
            return response()->json(['error' => 'No se pudo procesar tu pago. Actualiza tu aplicación Japam Móvil'], 400);
        }
        $request['ip'] = $request->getClientIp();
        try
        {
            DB::beginTransaction();
            $payControl = PayControl::where('receipt', $request['reference'])->first();

            if($payControl->pay_status == 'pagado'){
                return response()->json(['error' => 'El recibo ya fue pagado.'], 400);
            }
            $now = Carbon::now();
            if($now->day>=25){
                return response()->json(['error' => 'Sólo se permiten realizar referencias antes del día 25 de cada mes.'], 400);
            }

            PayControl::updateOrCreate(
                [ 'receipt' => $request['reference'] ],
                [
                    'app_user_id' => Auth::check() ? Auth::user()->id: null,
                    'receipt' => $request['reference'],

                    'barcode' => $request['barcode'],
                    'contract' => $request['contract'],
                    'consumptionPeriod' => $request['consumptionPeriod'],
                    'isExpiration' => $request['isExpiration'],

                    'description' => $request['description'],
                    'pay_date' => Carbon::now(),
                    'pay_method' => $request['store'],
                    'subtotal' => $request['subtotal'],
                    'total' => $request['amount'],
                    'platform' => is_null($request['platform']) ? 'android': $request['platform'],//'app',
                    'pay_status' => 'pendiente',
                    'app_version'=> $request['app_version']
                ]);

            //dd($payControl);
            $reference = $this->apiSrPago->convenienceStore($request);

            DB::commit();
            //PayControl::sendMailInstructionsPaymentStores($request, $reference);
            return response()->json(['msg' => 'Referencia generada correctamente.', 'reference'=>$reference]);
        }
        catch(\Exception $ex){
            DB::rollback();
            return response()->json(['error' => $ex->getMessage() ], 422);
            //return response()->json(['error' => 'Ocurrio un error al generar la referencia.'], 422);
        }
    }


    /*
        Mail::send('emails.app_credentials', [
            'name' => $request['name'],
            'email' => $request["email"],
            'password' => $request['password']
        ], function ($message) use ($request) {
            $message->subject("Reestablecimiento de Contraseña Japam Móvil")
                ->to($request["email"], $request["name"])
                //->bcc(['ventas2@xenonymas.com.mx', 'gerencia@ideasysolucionestecnologicas.com', 'depweb@ideasysolucionestecnologicas.com'])
                ->from('contacto@japam.gob.mx', 'Junta de Agua Potable y Alcantarillado Municipal');
        });
        */
}
