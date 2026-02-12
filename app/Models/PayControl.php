<?php

namespace App\Models;

use Mail;
use DateTime;
use Carbon\Carbon;
use Eloquent as Model;

/**
 * Class PayControl
 * @package App\Models
 * @version January 4, 2018, 4:41 pm CST
 *
 * @property \App\Models\AppUser appUser
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property integer app_user_id
 * @property integer uuid
 * @property string receipt
 * @property string|\Carbon\Carbon pay_date
 * @property float total
 * @property string pay_status
 */
class PayControl extends Model
{

    public $table = 'pay_control';

    public $timestamps = false;


    protected $primaryKey = 'id';

    public $fillable = [
        'app_user_id',
        'receipt',

        'barcode',
        'contract',
        'consumptionPeriod',
        'isExpiration',

        'description',
        'contract',
        'barcode',
        'consumptionPeriod',
        'isExpiration',
        'pay_date',
        'pay_method',
        'subtotal',
        'total',
        'platform',
        'pay_status',
        'app_version'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'app_user_id' => 'integer',
        'receipt' => 'string',

        'barcode' => 'string',
        'contract' => 'string',
        'consumptionPeriod' => 'string',
        'isExpiration' => 'integer',

        'description' => 'string',
        'contract' => 'string',
        'barcode' => 'string',
        'consumptionPeriod' => 'string',
        'isExpiration' => 'string',
        'pay_date' => 'string',
        'pay_method' => 'string',
        'subtotal' => 'float',
        'total' => 'float',
        'platform' => 'string',
        'pay_status' => 'string',
        'app_version' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function appUser()
    {
        return $this->belongsTo(\App\Models\AppUser::class);
    }

    public static function sendMailInstructionsPaymentStores($request, $reference){
        Mail::send('emails.instructions_payment_stores',
            [
                'store' => $request['store'],
                'expirationReference' => Carbon::parse($reference['expiration_date'])->format('d-M-Y'),
                'reference' => $request['reference'],
                'description' => $request['description'],
                'amount' => $request['amount'],
                'bank' => $reference['bank_name'],
                'account' => $reference['bank_account_number']
            ],
            function($messages) use($request) {
                $messages->to($request['email'])->subject('JAPAM');
            });
    }

    public static function sendReceiptPay($pay){
        $date = Carbon::parse( $pay['timestamp'])->format('d-m-Y H:i');//'2018-04-05T16:09:22-05:00'

        Mail::send('emails.receipt_payment', [
            'payDate' => $date,
            'reference' => $pay['reference']['number'],//'12161486',
            'transaction' =>  $pay['transaction'],//'MjY0NzMzMA',
            'authorization' =>  $pay['authorization_code'],//'1861285506',
            'description' =>  $pay['reference']['description'],//'Pago de Servicios. Contrato #18060-18060-30230. Periodo de Consumo: Marzo 2018',
            'amount' =>  $pay['total']['amount'],//'248.21',
            'holderName' => $pay['card']['holder_name'],//'Gustavo Pichardo Barcenas',
            'cardType' => $pay['card']['type'],//'MAST',
            'cardNumber' => $pay['card']['number'],//'0124',
            'lat' =>  $pay['origin']['location']['latitude'],//20.3748139,
            'lng' => $pay['origin']['location']['longitude'],//-99.9640802
        ], function ($message) use ($pay) {
            $message->subject("JAPAM - Recibo de Pago")
                ->to($pay['email'], $pay['card']['holder_name'])
                //->bcc(['drinsorz@gmail.com'])
                ->from('contacto@japam.gob.mx', 'Junta de Agua Potable y Alcantarillado Municipal');
        });
    }
}
