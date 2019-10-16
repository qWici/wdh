<?php

namespace App\Jobs;

use App\Models\Stream;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateTwitchStream implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /*
     *  Data incoming on Twitch webhook
     *  If array is empty - stream is going to offline
     */
    protected $twitchData;

    /*
     *  Twitch User ID
     */
    protected $twitchId;

    /**
     * Create a new job instance.
     *
     * @param $twitchData array
     * @param $twitchId int
     * @return void
     */
    public function __construct(array $twitchData, int $twitchId)
    {
        $this->twitchData = $twitchData;
        $this->twitchId = $twitchId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stream = Stream::where('twitch_id', $this->twitchId)->firstOrFail();

        if (empty($this->twitchData)) {
            info('Twitch stream is going offline ID: ' .  $this->twitchId);
            return $stream->update(['online' => false]);
        }

        info('Twitch stream is live | Data updated | ID: ' .  $this->twitchId);
        return $stream->update([
            'online' => true,
            'title' => $this->twitchData[0]['title'],
            'language' => $this->twitchData[0]['language']
        ]);
    }
}
