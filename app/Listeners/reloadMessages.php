<?php

namespace App\Listeners;

use App\Events\Comments;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class reloadMessages
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Comments  $event
     * @return void
     */
    public function handle(Comments $event)
    {
        //
    }
}
