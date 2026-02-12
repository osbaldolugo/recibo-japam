<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 01/02/2018
 * Time: 11:46 AM
 */

namespace App\Models;

use Eloquent AS Model;
use App\Models\Traits\DatesTranslator;

class Audits extends Model
{

    use DatesTranslator;

    public $table = 'ticketit_audits';

    public $timestamps = true;

    protected $dates = ['created_at', 'updated_at'];

    protected $primaryKey = 'id';

    public $fillable = [
        'operation',
        'icon',
        'user_id',
        'ticket_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'operacion' => 'string',
        'icon' => 'string',
        'user_id' => 'integer',
        'ticket_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public static $messages = [

    ];

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     **/
//    public function user()
//    {
//        return $this->belongsTo(\App\User::class, 'user_id');
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     **/
//    public function ticket()
//    {
//        return $this->belongsTo(\App\Models\Ticket::class, 'ticket_id');
//    }

}