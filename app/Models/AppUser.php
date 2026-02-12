<?php

namespace App\Models;

use Mail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AppUserResetPasswordNotification;

/**
 * Class AppUser
 * @package App\Models
 * @version January 4, 2018, 4:01 pm CST
 *
 * @property \App\Models\Person person
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection PayControl
 * @property \Illuminate\Database\Eloquent\Collection ReceiptUser
 * @property integer people_id
 * @property string email
 * @property string password
 * @property string phone_number
 * @property string remember_token
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class AppUser extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public $table = 'app_user';

    public $timestamps = false;


    protected $primaryKey = 'id';

    public $fillable = [
        'people_id',
        'email',
        'password',
        'phone_number',
        'acceptChallenge',
        'firebase_token',
        'verify_token',
        'activated',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'people_id' => 'integer',
        'email' => 'string',
        'password' => 'string',
        'phone_number' => 'string',
        'acceptChallenge' => 'string',
        'firebase_token' => 'string',
        'verify_token' => 'string',
        'activated' => 'integer',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AppUserResetPasswordNotification($token));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function people()
    {
        return $this->belongsTo(\App\Models\People::class, 'people_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function payControls()
    {
        return $this->hasMany(\App\Models\PayControl::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function appTicket()
    {
        return $this->hasMany(\App\Models\AppTicket::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function receipts()
    {
        return $this->belongsToMany(\App\Models\Receipt::class, 'receipt_user', 'app_user_id', 'receipt_id');
    }

    public static function sendCredentials($request)
    {
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
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function userReceipt()
    {
        return $this->belongsToMany(Receipt::class, 'receipt_user', 'app_user_id', 'receipt_id');
    }

    public static function generateToken()
    {
        /*
         * Se usa la función [openssl_random_pseudo_bytes] para generar una cadena de bytes pseudo-aleatoria
         * Posteriormente a esa cadena generada la convertimos a un valor hexadecimal con la función [bin2hex]
         * Y para estar seguros usamos la función [unniqid] que nos ayuda a generar un id unico de manera que generamos un token unico e irrepetible
         */
        return uniqid(bin2hex(openssl_random_pseudo_bytes(32, $cstrong)));
    }

}
