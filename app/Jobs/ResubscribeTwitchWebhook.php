<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ResubscribeTwitchWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /*
     *  Twitch User ID
     */
    protected $twitchId;

    /**
     * Create a new job instance.
     *
     * @param int $twitchId
     * @return void
     */
    public function __construct(int $twitchId)
    {
        $this->twitchId = $twitchId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info("Resubscribe Twitch webhook for ID: " . $this->twitchId);
        \Artisan::call('twitch:subscribe', ['twitch_id' => $this->twitchId]);
    }
}
