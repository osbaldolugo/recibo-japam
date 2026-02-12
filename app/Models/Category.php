<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Category
 * @package App\Models
 * @version July 12, 2018, 11:00 am CDT
 *
 * @property \Illuminate\Database\Eloquent\Collection appTicket
 * @property \Illuminate\Database\Eloquent\Collection appTicketImages
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection complaint
 * @property \Illuminate\Database\Eloquent\Collection incidentStep
 * @property \Illuminate\Database\Eloquent\Collection pmoMaterialWorktable
 * @property \Illuminate\Database\Eloquent\Collection PmoWorkTable
 * @property \Illuminate\Database\Eloquent\Collection pmoWorkerWorktable
 * @property \Illuminate\Database\Eloquent\Collection pmoWorkorderSuburbs
 * @property \Illuminate\Database\Eloquent\Collection PublishChannel
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property \Illuminate\Database\Eloquent\Collection SuscribeChannel
 * @property \Illuminate\Database\Eloquent\Collection Ticketit
 * @property \Illuminate\Database\Eloquent\Collection ticketitAudits
 * @property \Illuminate\Database\Eloquent\Collection TicketitCategoriesUser
 * @property \Illuminate\Database\Eloquent\Collection ticketitComments
 * @property \Illuminate\Database\Eloquent\Collection ticketitNotification
 * @property \Illuminate\Database\Eloquent\Collection ticketitUsersSubs
 * @property \Illuminate\Database\Eloquent\Collection ticketitsApp
 * @property string name
 * @property string color
 * @property boolean executor
 */
class Category extends Model
{

    public $table = 'ticketit_categories';

    public $timestamps = false;



    public $fillable = [
        'name',
        'color',
        'executor'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'color' => 'string',
        'executor' => 'boolean'
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
    public function pmoWorkTables()
    {
        return $this->hasMany(\App\Models\PmoWorkTable::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket', 'category_id');
    }

    /**
     * Get related agents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function agents()
    {
        return $this->belongsToMany('App\Models\Agent', 'ticketit_categories_users', 'category_id', 'user_id');
    }

    /**
     * Get related categories to publish.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function publishChannel()
    {
        return $this->belongsToMany('App\Models\Channel', 'publish_channel', 'category_id', 'channel_id');
    }

    /**
     * Get related categories to suscribe.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function suscribeChannel()
    {
        return $this->belongsToMany('App\Models\Channel', 'suscribe_channel', 'category_id', 'channel_id');
    }
}
