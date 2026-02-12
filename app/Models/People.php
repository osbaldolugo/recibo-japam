<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class People
 * @package App\Models
 * @version January 4, 2018, 3:48 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection AppUser
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property string name
 * @property string last_name_1
 * @property string last_name_2
 */
class People extends Model
{

    public $table = 'people';
    
    public $timestamps = false;


    protected $primaryKey = 'id';

    public $fillable = [
        'name',
        'last_name_1',
        'last_name_2'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'last_name_1' => 'string',
        'last_name_2' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function appUsers()
    {
        return $this->hasMany(\App\Models\AppUser::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user() {
        return $this->hasOne('App\Models\AppUser', 'people_id', 'id');
    }
}
