<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 11:15 AM
 */

namespace App\Models;

use Eloquent as Model;

class TicketitsApp extends Model
{
    public $table = 'ticketits_app';

    public $timestamps = false;

    public $fillable = [
        'app_ticket_id',
        'ticketit_id',
        'merged_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'app_ticket_id' => 'integer',
        'ticketit_id' => 'integer',
        'merged_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * Get Tickets App.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appTicket()
    {
        return $this->belongsTo(AppTicket::class);
    }

    /**
     * Get Tickets App Ticketit.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticketit()
    {
        return $this->belongsTo(Ticket::class);
    }
}