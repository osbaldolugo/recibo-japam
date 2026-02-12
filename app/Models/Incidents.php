<?php

namespace App\Models;

use App\Models\Traits\DatesTranslator;
use Eloquent as Model;

class Incidents extends Model
{
    use DatesTranslator;

    public $table = 'incidents';
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    public $fillable = [
        'name',
        'description',
        'ticket',
        'user_required',
        'receipt_required'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'ticket' => 'boolean',
        'user_required' => 'boolean',
        'receipt_required' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'required'
    ];

    public static $messages = [
        'name.required' => 'Se necesita especificar el nombre del motivo de llamada',
        'description.required' => 'Se requiere dar una breve descripción del motivo de llamada',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function steps()
    {
        return $this->hasMany(\App\Models\Steps::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function ticket()
    {
        return $this->hasMany(\App\Models\Ticket::class);
    }

    public function ticketStep() {
        return $this->belongsToMany(Steps::class, 'incident_step', 'incident_id', 'step_id');
    }
}
