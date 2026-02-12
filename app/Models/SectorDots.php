<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 12:43 PM
 */

namespace App\Models;

use Eloquent as Model;

class SectorDots extends Model
{
    public $table = 'sector_dots';

    public $timestamps = false;

    public $primaryKey = "id";


    public $fillable = [
        'sector_id',
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
        'sector_id' => 'integer',
        'lat' => 'float',
        'lng' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * Get Sector.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sector()
    {
        return $this->hasOne(Sector::class);
    }

}