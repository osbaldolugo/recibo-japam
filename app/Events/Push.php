<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Push implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    private $comment;
    private $ticket;
    private $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($comment,$ticket,$user)
    {
        $this->comment = $comment;
        $this->ticket = $ticket;
        $this->user = $user;
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("USER.".$this->user->id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['comment' => $this->comment,"ticket"=>$this->ticket];
    }
}
