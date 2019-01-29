<?php

namespace App\Events;

use Exception;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class HandleErrorEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $exception;

    /**
     * HandleErrorEvent constructor.
     * @param Exception $exception
     */
    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }
}
