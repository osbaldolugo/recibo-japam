<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Priority
 * @package App\Models
 * @version July 12, 2018, 12:17 pm CDT
 *
 * @property \Illuminate\Database\Eloquent\Collection appTicket
 * @property \Illuminate\Database\Eloquent\Collection appTicketImages
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection complaint
 * @property \Illuminate\Database\Eloquent\Collection incidentStep
 * @property \Illuminate\Database\Eloquent\Collection pmoMaterialWorktable
 * @property \Illuminate\Database\Eloquent\Collection pmoWorkerWorktable
 * @property \Illuminate\Database\Eloquent\Collection pmoWorkorderSuburbs
 * @property \Illuminate\Database\Eloquent\Collection publishChannel
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property \Illuminate\Database\Eloquent\Collection suscribeChannel
 * @property \Illuminate\Database\Eloquent\Collection Ticketit
 * @property \Illuminate\Database\Eloquent\Collection ticketitAudits
 * @property \Illuminate\Database\Eloquent\Collection ticketitCategoriesUsers
 * @property \Illuminate\Database\Eloquent\Collection ticketitComments
 * @property \Illuminate\Database\Eloquent\Collection ticketitNotification
 * @property \Illuminate\Database\Eloquent\Collection ticketitUsersSubs
 * @property \Illuminate\Database\Eloquent\Collection ticketitsApp
 * @property string name
 * @property string color
 * @property integer response_time
 */
class Priority extends Model
{

    public $table = 'ticketit_priorities';

    public $timestamps = false;



    public $fillable = [
        'name',
        'color',
        'response_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'color' => 'string',
        'response_time' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'color' => 'required',
        'response_time' => 'required|min:1'
    ];

    public static $messages = [
        'name.required' => 'Se debe especificar un nombre o descripción para identificar la prioridad',
        'color.required' => 'Se requiere de un color para poder separar e identificar cada prioridad',
        'response_time.required' => 'Es necesario especificar el tiempo de respuesta',
        'response_time.min' => 'El tiempo de respuesta no puede ser menor a un día'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket', 'priority_id');
    }
}
