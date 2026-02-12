<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class PMOWorkOrderSectorDots
 * @package App\Models
 * @version June 5, 2018, 2:10 pm CDT
 *
 * @property \App\Models\PmoWorkTable pmoWorkTable
 * @property \Illuminate\Database\Eloquent\Collection appTicket
 * @property \Illuminate\Database\Eloquent\Collection appTicketImages
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection complaint
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
 * @property integer pmo_work_table_id
 * @property integer lat
 * @property integer lng
 */
class PMOWorkOrderSectorDots extends Model
{

    public $table = 'pmo_workorder_sector_dots';
    
    public $timestamps = false;



    public $fillable = [
        'pmo_work_table_id',
        'lat',
        'lng'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'pmo_work_table_id' => 'integer',
        'lat' => 'integer',
        'lng' => 'integer'
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
    public function pmoWorkTable()
    {
        return $this->belongsTo(\App\Models\PmoWorkTable::class);
    }
}
