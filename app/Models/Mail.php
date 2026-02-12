<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Mail
 * @package App\Models
 * @version January 4, 2018, 4:34 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property string mail
 */
class Mail extends Model
{

    public $table = 'mail';
    
    public $timestamps = false;


    protected $primaryKey = 'id';

    public $fillable = [
        'mail'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mail' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
