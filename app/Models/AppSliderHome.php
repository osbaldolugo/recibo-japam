<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class AppSliderHome
 * @package App\Models
 * @version March 1, 2018, 11:42 pm CST
 *
 * @property app_slider_home image
 * @property app_slider_home status
 */
class AppSliderHome extends Model
{

    public $table = 'app_slider_home';

    public $timestamps = false;

    protected $primaryKey = 'id';

    public $fillable = [
        'image',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'image' => 'string',
        'status' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        /*'image' => 'required',
        'status' => 'required'*/
    ];

    
}
