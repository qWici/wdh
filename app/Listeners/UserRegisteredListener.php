<?php

namespace App\Listeners;

use App;
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
        if (App::environment('prod')) {
            $event->user->notify(new UserRegisteredNotification($event->user->nickname));
        }
    }
}
