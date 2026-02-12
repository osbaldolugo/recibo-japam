<?php

namespace App\Models;

use App\Models\Traits\DatesTranslator;
use Eloquent as Model;

/**
 * Class AppTicket
 * @package App\Models
 * @version January 10, 2018, 11:03 am CST
 *
 * @property \App\Models\AppUser appUser
 * @property \App\Models\Incident incident
 * @property \App\Models\PeopleUnlogged peopleUnlogged
 * @property \App\Models\Suburb suburb
 * @property \Illuminate\Database\Eloquent\Collection AppTicketImage
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property \Illuminate\Database\Eloquent\Collection ticketitAudits
 * @property \Illuminate\Database\Eloquent\Collection ticketitCategoriesUsers
 * @property \Illuminate\Database\Eloquent\Collection ticketitComments
 * @property \Illuminate\Database\Eloquent\Collection TicketitsApp
 * @property integer incidents_id
 * @property integer app_user_id
 * @property integer people_unlogged_id
 * @property string description
 * @property float latitude
 * @property float longitude
 * @property string street
 * @property string outside_number
 * @property string inside_number
 * @property integer suburb_id
 * @property string cp
 */
class AppTicket extends Model
{
    use DatesTranslator;
    public $table = 'app_ticket';
    public $timestamps = false;
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';

    public $fillable = [
        'app_user_id',
        'people_unlogged_id',
        'meter',
        'contract',
        'headline',
        'address',
        'description',
        'url_image',
        'latitude',
        'longitude',
        'report_type',
        'type',
        'origen'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'app_user_id' => 'integer',
        'people_unlogged_id' => 'integer',
        'meter' => 'string',
        'contract' => 'string',
        'headline' => 'string',
        'description' => 'string',
        'address' => "string",
        'type' => "string",
        'url_image' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
        'report_type'=>'string',
        'origen'=>'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'latitude' => 'required',
        'longitude' => 'required',
        'description' => 'required',
    ];

    public static $messages = [
        'latitude.required' => 'No se ha completado la dirección para determinar la latitud de la ubicación',
        'longitude.required' => 'No se ha completado la dirección para determinar la longitud de la ubicación',
        'description.required' => 'La descripción del reporte es requerida',
        /*'street.required' => 'No se ha determinado la calle de la ubicación',
        'outside_number.required' => 'No se ha determinado el No. exterior de la ubicación',
        'suburb.required' => 'No se ha determinado la colonia de la ubicación',
        'suburb.integer' => 'La información de la colonia no puede ser contrastada con la información del servidor',
        'cp.required' => 'No se ha determinado el código postal de la ubicación',
        'cp.digits_between' => 'El código postal no corresponde a uno de SJR'*/
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function appUser()
    {
        return $this->belongsTo(\App\Models\AppUser::class, 'app_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function peopleUnlogged()
    {
        return $this->belongsTo(\App\Models\PeopleUnlogged::class, 'people_unlogged_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function ticket()
    {
        return $this->belongsToMany(\App\Models\Ticket::class, 'ticketits_app', 'app_ticket_id', 'ticketit_id');
    }
}
