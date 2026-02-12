<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Notification
 * @package App\Models
 * @version January 4, 2018, 3:53 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property string title
 * @property string description
 * @property string url_image
 * @property string url_info
 * @property string|\Carbon\Carbon begin_date
 * @property string|\Carbon\Carbon end_date
 */
class Notification extends Model
{

    public $table = 'notification';
    
    public $timestamps = false;


    protected $primaryKey = 'id';

    public $fillable = [
        'title',
        'description',
        'url_image',
        'url_info',
        'begin_date',
        'end_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'url_image' => 'string',
        'url_info' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * Get Ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appTicket()
    {
        return $this->belongsToMany('App\Models\AppTicket', 'ticketits_app', 'ticketit_id', 'app_ticket_id');
    }
}
