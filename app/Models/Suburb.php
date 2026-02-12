<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 03:57 PM
 */

namespace App\Models;

use Eloquent as Model;

class Suburb extends Model
{
    public $table = 'suburbs';
    public $primaryKey = 'id';

    public $timestamps = false;

    public $fillable = [
        'suburb',
        'sector_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'suburb' => 'string',
        'sector_id' => 'integer',
        'lat' => 'float',
        'lng' => 'float',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class,"sector_id","id");
    }

    /**
     * Get Tickets App.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }
}