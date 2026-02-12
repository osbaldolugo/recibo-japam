<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 30/01/2018
 * Time: 12:52 PM
 */

namespace App\Models;

use Eloquent as Model;

class Steps extends Model
{

    protected $table = 'steps';
    public $timestamps = false;

    protected $primaryKey = 'id';

    public $fillable = [
        'incidents_id',
        'step',
        'section_two',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'incidents_id' => 'integer',
        'step' => 'integer',
        'section_two' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function incident()
    {
        return $this->belongsTo(\App\Models\Incidents::class);
    }

    public function stepIncident() {
        return $this->belongsToMany(Incidents::class, 'incident_step', 'step_id', 'incident_id');
    }

}