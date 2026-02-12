<?php

namespace App\Models;

use App\Models\Traits\DatesTranslator;
use Eloquent as Model;

/**
 * Class Complaint
 * @package App\Models
 * @version April 3, 2018, 9:35 am CDT
 *
 * @property \App\Models\AppUser appUser
 * @property \App\Models\PeopleUnlogged peopleUnlogged
 * @property \Illuminate\Database\Eloquent\Collection appTicket
 * @property \Illuminate\Database\Eloquent\Collection appTicketImages
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection incidentStep
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
 * @property \Illuminate\Database\Eloquent\Collection ticketitUsersSubs
 * @property \Illuminate\Database\Eloquent\Collection ticketitsApp
 * @property integer app_user_id
 * @property integer people_unlogged_id
 * @property string description
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 * @property string phone_number
 * @property string type
 */
class Complaint extends Model
{
    use DatesTranslator;

    public $table = 'complaint';
    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = false;



    public $fillable = [
        'app_user_id',
        'people_unlogged_id',
        'description',
        'recibo',
        'contrato',
        'type',
        'origen'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'app_user_id' => 'integer',
        'people_unlogged_id' => 'integer',
        'description' => 'string',
        'recibo' => 'string',
        'contrato' => 'string',
        'type' => 'string',
        'origen' => 'string'
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
        return $this->belongsTo(\App\Models\AppUser::class,"app_user_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function peopleUnlogged()
    {
        return $this->belongsTo(\App\Models\PeopleUnlogged::class,"people_unlogged_id");
    }
}
