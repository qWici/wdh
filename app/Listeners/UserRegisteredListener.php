<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Notifications\UserRegisteredNotification;

class UserRegisteredListener
{

    /**
     * Handle the event.
     *
     * @param  UserRegisteredEvent $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event)
    {
        $event->user->notify(new UserRegisteredNotification($event->user->nickname));
    }
}
