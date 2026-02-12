<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class PMOWorker
 * @package App\Models
 * @version February 15, 2018, 5:49 pm CST
 *
 * @property \App\Models\PmoSpeciality pmoSpeciality
 * @property \Illuminate\Database\Eloquent\Collection appTicket
 * @property \Illuminate\Database\Eloquent\Collection appTicketImages
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection pmoMaterialWorktable
 * @property \Illuminate\Database\Eloquent\Collection PmoWorkerWorktable
 * @property \Illuminate\Database\Eloquent\Collection pmoWorkorderSuburbs
 * @property \Illuminate\Database\Eloquent\Collection publishChannel
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property \Illuminate\Database\Eloquent\Collection suscribeChannel
 * @property \Illuminate\Database\Eloquent\Collection ticketitAudits
 * @property \Illuminate\Database\Eloquent\Collection ticketitCategoriesUsers
 * @property \Illuminate\Database\Eloquent\Collection ticketitComments
 * @property \Illuminate\Database\Eloquent\Collection ticketitNotification
 * @property \Illuminate\Database\Eloquent\Collection ticketitsApp
 * @property integer nom_id
 * @property integer speciality_id
 * @property float dairy_salary
 * @property string name
 */
class PMOWorker extends Model
{

    public $table = 'pmo_worker';
    
    public $timestamps = false;



    public $fillable = [
        'nom_id',
        'speciality_id',
        'dairy_salary',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nom_id' => 'integer',
        'speciality_id' => 'integer',
        'dairy_salary' => 'float',
        'name' => 'string'
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
    public function pmoSpeciality()
    {
        return $this->belongsTo(\App\Models\PmoSpeciality::class, 'speciality_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function pmoWorktables()
    {
        return $this->hasMany(\App\Models\PmoWorktable::class);
    }
}
