<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class AppSettings
 * @package App\Models
 * @version April 19, 2018, 1:54 pm CDT
 *
 * @property string pay_control
 */
class AppSettings extends Model
{

    public $table = 'app_settings';

    public $timestamps = false;

    protected $primaryKey = 'id';

    public $fillable = [
        'pay_control',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'pay_control' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
}
