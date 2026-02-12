<?php

namespace App\Models;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\App;
use Eloquent as Model;

/**
 * Class People
 * @package App\Models
 * @version January 4, 2018, 3:48 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection AppUser
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property string name
 * @property string last_name_1
 * @property string last_name_2
 */
class Push implements ShouldBroadcast
{

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'ticketQueue';
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        // TODO: Implement broadcastOn() method.
        
        return new PrivateChannel('TICKET');
    }

    /**
     * The event's broadcast name.
     *
     * @return string

    public function broadcastAs()
    {
        return 'TICKET';
    }

     */

    /**
     * Get the data to broadcast.
     *
     * @return array

    public function broadcastWith()
    {
        return ['id' => "ejemplo"];
    }
     */

    /**
     * Determine if this event should broadcast.
     *
     * @return bool

    public function broadcastWhen()
    {
        return true;
    }
     * */
}
