<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class PMOWorkOrderSuburbs
 * @package App\Models
 * @version June 5, 2018, 3:11 pm CDT
 *
 * @property \App\Models\Suburb suburb
 * @property \App\Models\PmoWorkTable pmoWorkTable
 * @property \Illuminate\Database\Eloquent\Collection appTicket
 * @property \Illuminate\Database\Eloquent\Collection appTicketImages
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection complaint
 * @property \Illuminate\Database\Eloquent\Collection incidentStep
 * @property \Illuminate\Database\Eloquent\Collection pmoMaterialWorktable
 * @property \Illuminate\Database\Eloquent\Collection pmoWorkerWorktable
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
 * @property integer suburb_id
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class PMOWorkOrderSuburbs extends Model
{

    public $table = 'pmo_workorder_suburbs';
    
    public $timestamps = false;



    public $fillable = [
        'pmo_work_table_id',
        'suburb_id',
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
        'pmo_work_table_id' => 'integer',
        'suburb_id' => 'integer'
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
    public function suburb()
    {
        return $this->belongsTo(\App\Models\Suburb::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function pmoWorkTable()
    {
        return $this->belongsTo(\App\Models\PmoWorkTable::class);
    }
}
