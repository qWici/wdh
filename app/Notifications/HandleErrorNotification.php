<?php

namespace App\Notifications;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class HandleErrorNotification extends Notification
{
    use Queueable;

    public $message;
    public $code;
    public $file;
    public $line;

    /**
     * HandleErrorNotification constructor.
     * @param Exception $exception
     */
    public function __construct(Exception $exception)
    {
        $this->message = $exception->getMessage();
        $this->code = $exception->getCode();
        $this->file = $exception->getFile();
        $this->line = $exception->getLine();
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
            ->content("*ERROR!* \nMessage: {$this->message}\nFile: {$this->file}\nLine: {$this->line}");
    }
}
