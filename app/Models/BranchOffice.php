<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class BranchOffice
 * @package App\Models
 * @version January 4, 2018, 3:56 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection BranchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property string description
 * @property string street
 * @property string inside_number
 * @property string outside_number
 * @property string settlement
 * @property string cp
 * @property float latitude
 * @property float longitude
 * @property string image
 * @property string number_phone
 * @property string extension
 */
class BranchOffice extends Model
{

    public $table = 'branch_office';
    
    public $timestamps = false;


    protected $primaryKey = 'id';

    public $fillable = [
        'description',
        'street',
        'inside_number',
        'outside_number',
        'settlement',
        'cp',
        'latitude',
        'longitude',
        'image',
        'number_phone',
        'extension'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'description' => 'string',
        'street' => 'string',
        'inside_number' => 'string',
        'outside_number' => 'string',
        'settlement' => 'string',
        'cp' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
        'image' => 'string',
        'number_phone' => 'string',
        'extension' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        /*'branch_office.description' => 'required',
        'branch_office.street' => 'required',
        'branch_office.settlement' => 'required',
        'branch_office.cp' => 'required',
        'branch_office.latitude' => 'required',
        'branch_office.longitude' => 'required',
        'branch_office.image' => 'required|mimes:jpeg,png,jpg,svg|dimensions:min_width=1100,min_height=600',*/
    ];

    public static $messages = [
        'branch_office.description.required' => 'Es necesario ingresar una descripción.',
        'branch_office.street.required' => 'Es necesario ingresar una calle.',
        'branch_office.settlement.required' => 'Es necesario ingresar una colonia.',
        'branch_office.cp.required' => 'Es necesario ingresar un código postal.',
        'branch_office.latitude.required' => 'Es necesario ingresar una latitud.',
        'branch_office.longitude.required' => 'Es necesario ingresar una longitud.',
        'branch_office.image.required' => 'Es necesario seleccionar una imagen.',
        'branch_office.image.dimensions' => 'La imagen debe de tener un tamaño minimo de 1100x600 píxeles.',
        'branch_office.image.mimes' => 'Formato de imagen no permitido.',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function branchOfficeSchedules()
    {
        return $this->hasMany(\App\Models\BranchOfficeSchedule::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     **/
    public function schedule()
    {
        return $this->belongsToMany(\App\Models\Schedule::class, 'branch_office_schedule', 'branch_office_id', 'schedule_id')->withPivot('id');
    }
}
