<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class AppUserCard
 * @package App\Models
 * @version March 7, 2018, 10:16 am CST
 *
 * @property \App\Models\AppUser appUser
 * @property \Illuminate\Database\Eloquent\Collection appTicket
 * @property \Illuminate\Database\Eloquent\Collection appTicketImages
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection pmoMaterialWorktable
 * @property \Illuminate\Database\Eloquent\Collection pmoWorkerWorktable
 * @property \Illuminate\Database\Eloquent\Collection pmoWorkorderSuburbs
 * @property \Illuminate\Database\Eloquent\Collection publishChannel
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property \Illuminate\Database\Eloquent\Collection suscribeChannel
 * @property \Illuminate\Database\Eloquent\Collection ticketitAudits
 * @property \Illuminate\Database\Eloquent\Collection ticketitCategoriesUsers
 * @property \Illuminate\Database\Eloquent\Collection ticketitComments
 * @property \Illuminate\Database\Eloquent\Collection ticketitNotification
 * @property \Illuminate\Database\Eloquent\Collection ticketitsApp
 * @property integer app_user_id
 * @property string owner
 * @property string number
 * @property string exp_month
 * @property string exp_year
 */
class AppUserCard extends Model
{

    public $table = 'app_user_card';

    public $timestamps = false;



    public $fillable = [
        'app_user_id',
        'owner',
        'number',
        'exp_month',
        'exp_year',
        'token',
        'default'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'app_user_id' => 'integer',
        'owner' => 'string',
        'number' => 'string',
        'exp_month' => 'string',
        'exp_year' => 'string',
        'token' => 'string',
        'default' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'owner'=>'required',
        'number'=> ['required','regex:/^(4[0-9]{6,})|(5[1-5][0-9]{5,}|222[1-9][0-9]{3,}|22[3-9][0-9]{4,}|2[3-6][0-9]{5,}|27[01][0-9]{4,}|2720[0-9]{3,})$/'],
        'exp_month'=>['required','regex:/^(0?[1-9]|1[012])$/'],
        'exp_year'=>['required','regex:/^(1?[8-9]{1}|4?[0]{1}|[2-3]{1}[0-9]{1})$/']
    ];

    public static $messages=[
        'owner.required'=>'Debe indicar el nombre del tarjeta habiente',
        'number.required'=>'El no de tarjeta es obligatorio',
        'number.regex'=>'El no de tarjeta es inválido',
        'exp_month.required'=>'El mes de expiración es obligatorio',
        'exp_month.regex'=>'El mes de expiración es inválido',
        'exp_year.required'=>'El año de expiración es obligatorio',
        'exp_year.regex'=>'El año de expiración es inválido'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function appUser()
    {
        return $this->belongsTo(\App\Models\AppUser::class);
    }
}
