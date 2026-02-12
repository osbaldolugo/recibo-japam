<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 09/02/2018
 * Time: 10:33 AM
 */

namespace App\Models;


use Eloquent as Model;

class TicketitNotification extends Model
{
    public $table = 'ticketit_notification';

    public $timestamps = false;

    protected $dates = ['created_at', 'updated_at'];

    protected $primaryKey = 'id';

    public $fillable = [
        'user_receipt_id',
        'comment_id',
        'view'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_receipt_id' => 'integer',
        'comment_id' => 'integer',
        'view' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


    /**
     * Get Comment Information
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function comment()
    {
        return $this->hasOne('App\Models\Comment','id', 'comment_id');
    }

}