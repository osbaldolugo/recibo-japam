<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 09/02/2018
 * Time: 10:55 AM
 */

namespace App\Models;

use Eloquent as Model;

class Channel extends Model
{
    protected $table = 'channel';

    public $timestamps = false;

    protected $primaryKey = 'id';

    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * Get related categories to publish.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function publishCategory()
    {
        return $this->belongsToMany('App\Models\Category', 'publish_channel', 'channel_id', 'category_id');
    }

    /**
     * Get related categories to suscribe.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function suscribeCategory()
    {
        return $this->belongsToMany('App\Models\Category', 'suscribe_channel', 'channel_id', 'category_id');
    }
}