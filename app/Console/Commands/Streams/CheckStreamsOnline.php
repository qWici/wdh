<?php

namespace App\Console\Commands\Streams;

use App\Helpers\RemoteRequest;
use App\Models\Stream;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckStreamsOnline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:streams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check streams online';

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
        foreach (Stream::cursor() as $stream) {
            $nickname = $stream->twitch;
            $live = $this->check($nickname);

            if($live && !$stream->online) {
                Stream::where('id', $stream->id)->update([
                    'online' => true,
                    'title' => $live->title,
                    'language' => $live->language
                ]);
                continue;
            }

            if(!$live && $stream->online) {
                Stream::where('id', $stream->id)->update(['online' => false]);
            }
        }
        \Log::info("Streams Updated");
    }


    /**
     * Check if stream is live
     *
     * @param $streamNickname
     * @return bool
     */
    public function check($streamNickname)
    {
        $additionalParams = [
            'headers' => [
                'Client-ID' => env('TWITCH_CLIENT_ID')
            ]
        ];
        $url = "https://api.twitch.tv/helix/streams?user_login=${streamNickname}";
        $response = RemoteRequest::getRemoteContent($url, $additionalParams);
        if ($response['error']) {
            return false;
        }
        try {
            $data = json_decode($response['data']);
            if(! empty($data->data)) {
                return $data->data[0];
            }
            return false;
        } catch (\ErrorException $e) {}
    }
}
