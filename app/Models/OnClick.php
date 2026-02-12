<?php

namespace App\Models;;

use Eloquent as Model;


class OnClick extends Model
{
    public $table = 'onclick_counts';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'click_consulta_web',
        'click_consulta_app',
        'click_pagolink_web',
        'click_pagolink_app'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'click_consulta_web' => 'integer',
        'click_consulta_app' => 'integer',
        'click_pagolink_web' => 'integer',
        'click_pagolink_app' => 'integer',
    ];

}
