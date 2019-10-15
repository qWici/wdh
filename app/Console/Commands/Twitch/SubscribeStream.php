<?php

namespace App\Console\Commands\Twitch;

use App\Models\Stream;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SubscribeStream extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitch:subscribe
                            {twitch_id : Twitch user ID. Pass 0 for subscribe all streams from DB}
                            {customUrl? : Provide custom dev domain URL like ngrok etc}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to Twitch webhook on channel update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $twitchId = $this->argument('twitch_id');

        if ($twitchId) {
            return $this->subscribe($twitchId);
        }

        foreach (Stream::cursor() as $stream) {
            $this->subscribe($stream->twitch_id);
        }
    }

    private function subscribe($twitchId)
    {
        $customUrl = $this->argument('customUrl');

        $callbackUrl = $customUrl
            ? $customUrl . route('twitch.subscribe', ['twitch_id' => $twitchId], false)
            : route('twitch.subscribe', ['twitch_id' => $twitchId]);

        $client = new Client();
        try {
            $response = $client->post('https://api.twitch.tv/helix/webhooks/hub', [
                'headers' => [
                    'Client-ID' => env('TWITCH_CLIENT_ID')
                ],
                'json' => [
                    'hub.callback' => $callbackUrl,
                    'hub.mode' => 'subscribe',
                    'hub.topic' => 'https://api.twitch.tv/helix/streams?user_id=' . $twitchId,
                    'hub.lease_seconds' => 0, // 240 hours - max of subscription duration
                    'hub.secret	' => env('TWITCH_CLIENT_SECRET')
                ]
            ]);

            $this->info('Twitch subscription success');
            return true;
        } catch (\ErrorException $exception) {
            $this->error('Twitch subscription failed');
            $this->error($exception->getMessage());
        }

        return false;
    }
}
