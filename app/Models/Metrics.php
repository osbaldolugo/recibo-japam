<?php

namespace App\Models;

use Eloquent as Model;


/**
 * Class Car
 * @package App\Models
 * @version July 22, 2018, 4:21 pm CDT
 *
 * @property string name
 * @property string description
 */
class Metrics extends Model
{

    public $table = 'metrics';

    public $timestamps = false;

    protected $primaryKey = 'id';

    public $fillable = [
        'name',
        'contract',
        'site',
        'boton_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'integer',
        'contract' => 'string',
        'site' => 'string',
        'boton_type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}