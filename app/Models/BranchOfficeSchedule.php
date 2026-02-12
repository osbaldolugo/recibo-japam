<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class BranchOfficeSchedule
 * @package App\Models
 * @version January 4, 2018, 4:40 pm CST
 *
 * @property \App\Models\BranchOffice branchOffice
 * @property \App\Models\Schedule schedule
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property integer branch_office_id
 * @property integer schedule_id
 */
class BranchOfficeSchedule extends Model
{

    public $table = 'branch_office_schedule';
    
    public $timestamps = false;


    protected $primaryKey = 'id';

    public $fillable = [
        'branch_office_id',
        'schedule_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'branch_office_id' => 'integer',
        'schedule_id' => 'integer'
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
    public function branchOffice()
    {
        return $this->belongsTo(\App\Models\BranchOffice::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function schedule()
    {
        return $this->belongsTo(\App\Models\Schedule::class);
    }
}
