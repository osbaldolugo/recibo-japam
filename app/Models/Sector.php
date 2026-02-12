<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 12:43 PM
 */

namespace App\Models;

use Eloquent as Model;

class Sector extends Model
{
    public $table = 'sector';

    public $primaryKey = "id";

    public $timestamps = false;

    public $fillable = [
        'code',
        'name',
        'background'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string',
        'background' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * Get Suburbs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suburb()
    {
        return $this->hasMany(Suburb::class);
    }

    public function sectorDots()
    {
        return $this->hasMany(SectorDots::class, 'sector_id', 'id');
    }

}