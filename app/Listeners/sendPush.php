<?php

namespace App\Listeners;

use App\Events\Push;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendPush
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
     * @param  Push  $event
     * @return void
     */
    public function handle(Push $event)
    {
        //
    }
}
