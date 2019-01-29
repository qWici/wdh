<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class UserRegisteredNotification extends Notification
{
    use Queueable;

    public $nickname;

    /**
     * UserRegisteredListener constructor.
     * @param string $userNickname
     */
    public function __construct(string $userNickname)
    {
        $this->nickname = $userNickname;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    /**
     * Send notification to Telegram
     *
     * @param $notifiable
     * @return TelegramMessage
     */
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to('-1001257451662')
            ->content("*New user!* \nNickname: {$this->nickname}");
    }
}
