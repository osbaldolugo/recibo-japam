<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class PMOWorkTableFinish
 * @package App\Models
 * @version March 1, 2018, 10:57 am CST
 *
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
 * @property \Illuminate\Database\Eloquent\Collection ticketitUsersSubs
 * @property \Illuminate\Database\Eloquent\Collection ticketitsApp
 * @property integer pmo_work_table_id
 * @property time work_time
 * @property integer cause_id
 * @property integer supervisory_id
 * @property integer captured_id
 * @property float tools_cost
 * @property float other_cost
 */
class PMOWorkTableFinish extends Model
{

    public $table = 'pmo_work_table_finish';
    
    public $timestamps = false;



    public $fillable = [
        'pmo_work_table_id',
        'work_time',
        'cause_id',
        'supervisory_id',
        'captured_id',
        'tools_cost',
        'other_cost'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'pmo_work_table_id' => 'integer',
        'cause_id' => 'integer',
        'supervisory_id' => 'integer',
        'captured_id' => 'integer',
        'tools_cost' => 'float',
        'other_cost' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
