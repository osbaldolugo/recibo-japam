<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Schedule
 * @package App\Models
 * @version January 4, 2018, 4:46 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection BranchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property string area
 * @property string work_day
 * @property time begin_time
 * @property time end_time
 */
class Schedule extends Model
{

    public $table = 'schedule';
    
    public $timestamps = false;


    protected $primaryKey = 'id';

    public $fillable = [
        'area',
        'work_day',
        'begin_time',
        'end_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'area' => 'string',
        'work_day' => 'string'
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
    public function branchOfficeSchedules()
    {
        return $this->hasMany(\App\Models\BranchOfficeSchedule::class);
    }
}
