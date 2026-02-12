<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 22/02/2018
 * Time: 12:29 PM
 */

namespace App\Models;

use Eloquent as Model;

class TicketitMerge extends Model
{

    protected $table = 'ticketit_merge';

    public $timestamps = false;
    protected $dates = ['created_at'];

    protected $primaryKey = 'id';

    public $fillable = [
        'ticket_father',
        'ticket_son',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ticket_father' => 'integer',
        'ticket_son' => 'string',
        'user_id' => 'string'
    ];

    /**
     * Get Ticket Merge Son.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mergeSon()
    {
        return $this->belongsTo(\App\Models\Ticket::class, 'ticket_son');
    }

    /**
     * Get Ticket Merge Son.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mergeFather()
    {
        return $this->belongsTo(\App\Models\Ticket::class, 'ticket_father');
    }

}