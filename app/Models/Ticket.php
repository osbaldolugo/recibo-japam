<?php

namespace App\Models;

use App\Models\Traits\DatesTranslator;
use Eloquent as Model;
use Jenssegers\Date\Date;
use App\Models\Traits\ContentEllipse;
use App\Models\Traits\Purifiable;

class Ticket extends Model
{
    use ContentEllipse;
    use Purifiable;
    use DatesTranslator;

    protected $table = 'ticketit';
    protected $dates = ['completed_at', 'created_at', 'updated_at'];

    protected $primaryKey = 'id';

    public $fillable = [
        'folio',
        'content',
        'html',
        'street',
        'outside_number',
        'inside_number',
        'cp',
        'status',
        'latitude',
        'longitude',
        'suburb_id',
        'priority_id',
        'user_id',
        'agent_id',
        'category_id',
        'incidents_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'folio' => 'integer',
        'content' => 'string',
        'html' => 'string',
        'street' => 'string',
        'outside_number' => 'string',
        'inside_number' => 'string',
        'cp' => 'string',
        'status' => 'string',
        'latitude' => 'double',
        'longitude' => 'double',
        'suburb_id' => 'integer',
        'priority_id' => 'integer',
        'user_id' => 'integer',
        'agent_id' => 'integer',
        'category_id' => 'integer',
        'incidents_id' => 'integer'
    ];

    /**
     * List of completed tickets.
     *
     * @return bool
     */
    public function hasComments()
    {
        return (bool)count($this->comments);
    }

    public function isComplete()
    {
        return (bool)$this->completed_at;
    }

    /**
     * List of completed tickets.
     *
     * @return Collection
     */
    public function scopeComplete($query)
    {
        return $query->whereNotNull('completed_at');
    }

    /**
     * List of active tickets.
     *
     * @return Collection
     */
    public function scopeActive($query)
    {
        return $query->whereNull('completed_at');
    }

    /**
     * Get Ticket priority.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority()
    {
        return $this->belongsTo('App\Models\Priority', 'priority_id');
    }

    /**
     * Get Ticket category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    /**
     * Get Ticket owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get Ticket agent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo('App\Models\Agent', 'agent_id');
    }

    /**
     * Get WorkControl.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pmo_worktable()
    {
        return $this->hasMany('App\Models\PMOWorkTable', 'ticket_id')->with("pmoWork")->with("pmoCategory")->with("pmoEquipment");
    }

    /**
     * Get Ticket comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'ticket_id')->orderByDesc('created_at');
    }

    /**
     * Get Ticket user Subs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userSubs()
    {
        return $this->belongsToMany('App\Models\Agent', "ticketit_users_subs", "ticket_id", "user_id");
    }

    /**
     * Get Ticket user Subs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userSubsI()
    {
        return $this->belongsToMany('App\Models\Agent', "ticketit_users_subs", "ticket_id", "user_id")->where('user_id', \Auth::user()->id);
    }

    /**
     * Get Ticket comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastComment()
    {
        return $this->hasOne('App\Models\Comment', 'ticket_id')->latest();
    }

    /**
     * Get Ticket App.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appTicket()
    {
        return $this->belongsToMany('App\Models\AppTicket', 'ticketits_app', 'ticketit_id', 'app_ticket_id');
    }

    /**
     * Get Ticket App.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incident()
    {
        return $this->belongsTo(\App\Models\Incidents::class, 'incidents_id');
    }

    /**
     * Get WorkOrder .
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pmo_work_table()
    {
        return $this->hasOne(\App\Models\PMOWorkTable::class, 'ticket_id');
    }

    /**
     * Get Ticket Merge Son.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mergeSon()
    {
        return $this->hasOne(TicketitMerge::class, 'ticket_son');
    }

    /**
     * Get Ticket Merge Father.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mergeFather()
    {
        return $this->hasMany(TicketitMerge::class, 'ticket_father');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function suburb()
    {
        return $this->belongsTo(\App\Models\Suburb::class, 'suburb_id');
    }

    /**
     * @see Illuminate/Database/Eloquent/Model::asDateTime
     */
    public function freshTimestamp()
    {
        return new Date();
    }

    /**
     * @see Illuminate/Database/Eloquent/Model::asDateTime
     */
    protected function asDateTime($value)
    {
        if (is_numeric($value)) {
            return Date::createFromTimestamp($value);
        } elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value)) {
            return Date::createFromFormat('Y-m-d', $value)->startOfDay();
        } elseif (!$value instanceof \DateTime) {
            $format = $this->getDateFormat();

            return Date::createFromFormat($format, $value);
        }

        return Date::instance($value);
    }

    /**
     * Get all user tickets.
     *
     * @param $query
     * @param $id
     *
     * @return mixed
     */
    public function scopeUserTickets($query, $id)
    {
        return $query->where('user_id', $id);
    }

    /**
     * Get all agent tickets.
     *
     * @param $query
     * @param $id
     *
     * @return mixed
     */
    public function scopeAgentTickets($query, $id)
    {
        return $query->where('agent_id', $id);
    }

    /**
     * Get all agent tickets.
     *
     * @param $query
     * @param $id
     *
     * @return mixed
     */
    public function scopeAgentUserTickets($query, $id)
    {
        return $query->where(function ($subquery) use ($id) {
            $subquery->where('agent_id', $id)->orWhere('user_id', $id);
        });
    }

    /**
     * Sets the agent with the lowest tickets assigned in specific category.
     *
     * @return Ticket
     */
    public function autoSelectAgent()
    {
        $cat_id = $this->category_id;
        $agents = Category::find($cat_id)->agents()->with(['agentTotalTickets' => function ($query) {
            $query->addSelect(['id', 'agent_id']);
        }])->get();
        $count = 0;
        $lowest_tickets = 1000000;
        // If no agent selected, select the admin
        $first_admin = Agent::admins()->first();
        $selected_agent_id = empty($first_admin) ? \Auth::user()->id : $first_admin->id;
        foreach ($agents as $agent) {
            if ($count == 0) {
                $lowest_tickets = $agent->agentTotalTickets->count();
                $selected_agent_id = $agent->id;
            } else {
                $tickets_count = $agent->agentTotalTickets->count();
                if ($tickets_count < $lowest_tickets) {
                    $lowest_tickets = $tickets_count;
                    $selected_agent_id = $agent->id;
                }
            }
            $count++;
        }
        $this->agent_id = $selected_agent_id;

        return $this;
    }

    /**
     * Returns the next folio number
     * @return Ticket
     */
    public function nextFolio()
    {
        $ticket = Ticket::max('folio');
        if (empty($ticket))
            $this->folio = env('FOLIOTICKET', 1);
        else {
            $this->folio = $ticket + 1;
        }
        return $this;
    }

    //Busca si la categoria a la que tiene acceso el usuario se le hes permitido ciertos permisos
    public static function isGlobalView()
    {
        if (\Auth::check()) {
            $categories = Category::where('executor', true)->whereHas('agents', function ($query) {
                $query->where('users.id', \Auth::user()->id);
            })->get();
            if (count($categories))
                return true;
            else
                return false;
        } else
            return false;
    }

}
