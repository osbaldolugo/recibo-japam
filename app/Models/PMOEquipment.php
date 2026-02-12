<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class PMOEquipment
 * @package App\Models
 * @version February 16, 2018, 9:14 am CST
 *
 * @property \Illuminate\Database\Eloquent\Collection appTicket
 * @property \Illuminate\Database\Eloquent\Collection appTicketImages
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection pmoMaterialWorktable
 * @property \Illuminate\Database\Eloquent\Collection PmoWorkTable
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
 * @property string description
 * @property string code
 * @property string|\Carbon\Carbon deleted_at
 */
class PMOEquipment extends Model
{

    public $table = 'pmo_equipment';
    
    public $timestamps = false;



    public $fillable = [
        'description',
        'code',
        'deleted_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

        'description' => 'string',
        'code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function pmoWorkTables()
    {
        return $this->hasMany(\App\Models\PmoWorkTable::class);
    }
}
