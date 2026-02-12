<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class PeopleUnlogged
 * @package App\Models
 * @version January 11, 2018, 8:57 am CST
 *
 * @property \App\Models\Receipt receipt
 * @property \Illuminate\Database\Eloquent\Collection AppTicket
 * @property \Illuminate\Database\Eloquent\Collection appTicketImages
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property \Illuminate\Database\Eloquent\Collection ticketitAudits
 * @property \Illuminate\Database\Eloquent\Collection ticketitCategoriesUsers
 * @property \Illuminate\Database\Eloquent\Collection ticketitComments
 * @property \Illuminate\Database\Eloquent\Collection ticketitsApp
 * @property string name
 * @property string last_name_1
 * @property string last_name_2
 * @property integer receipt_id
 * @property string phone_number
 * @property string email
 */
class PeopleUnlogged extends Model
{

    public $table = 'people_unlogged';

    public $timestamps = false;



    public $fillable = [
        'name',
        'last_name_1',
        'last_name_2',
        'receipt_id',
        'phone_number',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'last_name_1' => 'string',
        'last_name_2' => 'string',
        'receipt_id' => 'integer',
        'phone_number' => 'string',
        'email' => 'string'
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
    public function receipt()
    {
        return $this->belongsTo(\App\Models\Receipt::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function appTickets()
    {
        return $this->hasOne(\App\Models\AppTicket::class);
    }
}
