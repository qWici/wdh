<?php

namespace App\Listeners;

use Notification;
use App\Models\User;
use App\Notifications\HandleErrorNotification;
use App\Events\HandleErrorEvent;

class HandleErrorListener
{
    /**
     * Handle the event.
     *
     * @param  HandleErrorEvent  $event
     * @return void
     */
    public function handle(HandleErrorEvent $event)
    {
        Notification::sendNow(User::first(), new HandleErrorNotification($event->exception));
    }
}
