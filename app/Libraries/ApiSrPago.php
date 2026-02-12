<?php

namespace App\Libraries;
error_reporting(0);

include_once app_path() . '/../SrPago/vendor/tcdent/php-restclient/restclient.php';
include_once app_path() . '/../SrPago/init.php';

use Mockery\Exception;
use SrPago\SrPago;

class ApiSrPago
{
    /*
     * Developer Mode Tu Ruta San Juan
     *
    private $isProduction = false;
    private $apiSecret = 'Xv_=YvPb=xPJ';
    private $apiKey = '79ac6d83-e559-45c0-8b77-1fdc4430188d';
*/

    /*
     * Developer Mode Japam
     *
    private $isProduction = false;
    private $apiSecret = '!eYd9y=Pyze=';
    private $apiKey = '25eba9b2-6512-434e-b85a-1b5d55f5e85b';
*/
    /*
    * Production Mode Japam
    */
    private $isProduction = true;
    private $apiSecret = 'itSbfLsbS4Z6';
    private $apiKey = 'fc12b40b-d89c-4451-b50b-d9bb4f4f93fb';

    /**
     * ApiSrPago constructor.
     */
    

    /**
     * Generate card payment
     * @param $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function cardPayment($request)
    {
        try {
            $chargeParams = [
                'amount' => $request['amount'],//343.69,
                'description' => $request['description'],//'Servicio de Agua Potable. Contrato # 27139-27139-14092 Enero 2018',
                'reference' => $request['reference'],// 'japam-movil-12107022',
                'source' => $request['token'],//'tok_5aa6a1053181f',
                'ip' => $request['ip'],
                'latitude' => $request['lat'],
                'longitude' => $request['lng']
            ];
            /*
             * OPTIONAL: Add metadata information to fraud prevention rules
             */
            $metadata = [
                "billing" => [
                    "billingEmailAddress" => $request['email'],
                    "billingFirstName-D" => $request['name'],
                    "billingMiddleName-D" => '',
                    "billingLastName-D" => $request['lastname'],
                    "billingAddress-D" => $request['street'] . ' ' . $request['outsideNum'], //"Arkansas 16"
                    "billingAddress2-D" => $request['settlement'],
                    "billingCity-D" => "San Juan del Río",
                    "billingState-D" => "Querétaro",
                    "billingPostalCode-D" => "76800",
                    "billingCountry-D" => "MX",
                    "billingPhoneNumber-D" => $request['phoneNumber'],
                    "creditCardAuthorizedAmount-D" => $request['amount']
                ],
                "items" => [
                    "item" => [
                        [
                            "itemNumber" => $request['reference'],//"193487654",
                            "itemDescription" => $request['description'],//"iPhone 6 32gb",
                            "itemPrice" => $request['amount'],//"599.00",
                            "itemQuantity" => 1,
                            "itemMeasurementUnit" => "Servicio",
                            "itemBrandName" => "Japam",
                            "itemCategory" => "Servicio",
                            "itemTax" => 0.00
                        ],
                    ]
                ]
            ];
            $chargeParams['metadata'] = $metadata;
            $chargesService = new \SrPago\Charges();
            $newCharge = $chargesService->create($chargeParams);
            return $newCharge;
        } catch (\Exception $e) {

            $msg = $e->getError()['message'] ? $e->getError()['message'] : $e->getMessage();

            $code = explode(":", $msg);
            if(isset($code)){
                switch ($code[0]){
                    case 'LKDECOM1':
                        $msg='El ​cliente ​ha ​intentado ​realizar ​múltiples transacciones ​desde ​la ​misma ​IP.';
                        break;
                    case 'LKDECOM2':
                        $msg='El ​cliente ​ha ​intentado ​múltiples ​cobros ​con ​la misma ​tarjeta, intente más tarde.';
                        break;
                    case 'LKDECOM3':
                    case 'LKDECOM4':
                        $msg='El servicio de cobro no esta disponible por el momento, intente más tarde.';
                        break;
                    case 'LKDECOM5':
                        $msg='Número ​de ​tarjeta ​no ​válido ​o ​restringido ​para su ​uso.';
                        break;
                }
            }

            throw new Exception($msg);
        }
    }

    /**
     * Generate a reference to the convenience store
     * @param $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function convenienceStore($request)
    {
        try {
            $chargeParams = [
                'amount' => $request['amount'],//343.69,
                'description' => $request['description'],//'Servicio de Agua Potable. Contrato # 27139-27139-14092 Enero 2018',
                'reference' => $request['reference'],// 'japam-movil-12107022',
                'store' => $request['store'],//'OXXO'
                'email' => $request['email'],//'drinsorz@gmail.com'
                'ip' => $request['ip'],
                'latitude' => $request['lat'],
                'longitude' => $request['lng']
            ];
            $convenienceStore = new \SrPago\ConveniencieStore();
            $newCharge = $convenienceStore->create($chargeParams);
            return $newCharge;
        } catch (\Exception $e) {
            $msg = $e->getError()['message'] ? $e->getError()['message'] : $e->getMessage();
            throw new Exception($msg);
            //return response()->json(['error' => $msg ], 422);
        }
    }

    /**
     * Get operations Sr Pago
     * @param $data
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function operations($data)
    {
        $operations = new \SrPago\Operations();
        $parameters = [
            'start_date' => $data['startDate'],
            'end_date' => $data['endDate'],
            'payment_method' => $data['paymentMethod']
        ];
        $listOperations = $operations->all($parameters);
        return $listOperations;
    }
}
