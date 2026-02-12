<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class PMOWorkTable
 * @package App\Models
 * @version February 28, 2018, 11:04 am CST
 *
 * @property \App\Models\PmoEquipment pmoEquipment
 * @property \App\Models\PmoWork pmoWork
 * @property \App\Models\PmoWorktype pmoWorktype
 * @property \App\Models\Category Category
 * @property \App\Models\Ticket ticketIT
 * @property \App\User user
 * @property \Illuminate\Database\Eloquent\Collection appTicket
 * @property \Illuminate\Database\Eloquent\Collection appTicketImages
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection PmoMaterialWorktable
 * @property \Illuminate\Database\Eloquent\Collection PmoWorkerWorktable
 * @property \Illuminate\Database\Eloquent\Collection PmoWorkorderSectorDot
 * @property \Illuminate\Database\Eloquent\Collection PmoWorkorderSuburb
 * @property \Illuminate\Database\Eloquent\Collection publishChannel
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property \Illuminate\Database\Eloquent\Collection suscribeChannel
 * @property \Illuminate\Database\Eloquent\Collection ticketitAudits
 * @property \Illuminate\Database\Eloquent\Collection ticketitCategoriesUsers
 * @property \Illuminate\Database\Eloquent\Collection ticketitComments
 * @property \Illuminate\Database\Eloquent\Collection ticketitNotification
 * @property \Illuminate\Database\Eloquent\Collection ticketitUsersSubs
 * @property \Illuminate\Database\Eloquent\Collection ticketitsApp
 * @property integer ticket_id
 * @property integer user_id
 * @property integer folio
 * @property integer work_id
 * @property integer equipment_id
 * @property integer worktype_id
 * @property string status
 * @property string|\Carbon\Carbon deadline
 * @property integer executor_category_id
 * @property time work_time
 * @property integer cause_id
 * @property integer supervisory_id
 * @property integer captured_id
 * @property float tools_cost
 * @property float other_cost
 */
class PMOWorkTable extends Model
{

    public $table = 'pmo_work_table';
    
    public $timestamps = false;



    public $fillable = [
        'ticket_id',
        'user_id',
        'folio',
        'work_id',
        'equipment_id',
        'worktype_id',
        'status',
        'deadline',
        'executor_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ticket_id' => 'integer',
        'user_id' => 'integer',
        'folio' => 'integer',
        'work_id' => 'integer',
        'equipment_id' => 'integer',
        'worktype_id' => 'integer',
        'status' => 'string',
        'executor_category_id' => 'integer'
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
    public function pmoEquipment()
    {
        return $this->belongsTo(\App\Models\PMOEquipment::class,"equipment_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function pmoWork()
    {
        return $this->belongsTo(\App\Models\PMOWork::class,"work_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function pmoWorktype()
    {
        return $this->belongsTo(\App\Models\PMOWorkType::class,"worktype_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function pmoCategory()
    {
        return $this->belongsTo(\App\Models\Category::class,"executor_category_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function ticketit()
    {
        return $this->belongsTo(\App\Models\Ticket::class,"ticket_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\User::class,"user_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function pmoMaterialWorktables()
    {
        return $this->hasMany(\App\Models\PMOMaterial::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function pmoWorkerWorktables()
    {
        return $this->hasMany(\App\Models\PMOWorker::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function pmoWorkorderSectorDots()
    {
        return $this->hasMany(\App\Models\PMOWorkOrderSectorDots::class,'pmo_work_table_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function pmoWorkorderSuburbs()
    {
        return $this->hasMany(\App\Models\PMOWorkOrderSuburbs::class,"pmo_work_table_id");
    }

}
