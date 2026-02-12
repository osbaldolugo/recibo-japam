<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 11:45 AM
 */

namespace App\Models;

use Eloquent as Model;

class AppTicketImage extends Model
{

    public $table = 'app_ticket_images';

    public $timestamps = false;

    public $fillable = [
        'images_id',
        'app_tickets_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'images_id' => 'integer',
        'app_tickets_id' => 'integer'
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
        return $this->belongsTo(AppTicket::class, 'app_tickets_id');
    }

    /**
     * Get Tickets App Ticketit.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticketit()
    {
        return $this->belongsTo(Image::class, 'images_id');
    }

}