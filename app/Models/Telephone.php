<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Telephone
 * @package App\Models
 * @version January 4, 2018, 4:48 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property string number_phone
 */
class Telephone extends Model
{

    public $table = 'telephone';
    
    public $timestamps = false;


    protected $primaryKey = 'id';

    public $fillable = [
        'number_phone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'number_phone' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
