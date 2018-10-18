<?php

namespace App\Console\Commands;

use App\Helpers\RemoteRequest;
use App\Models\Stream;
use App\Models\StreamTag;
use Illuminate\Console\Command;

class ParseStreams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:streams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse streams';

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
        $this->getLinksToJSON();
    }

    public function getLinksToJSON()
    {
        $response = RemoteRequest::getRemoteContent('https://gitlab.com/api/v4/projects/8927048/repository/files/streamers.min.json/raw?ref=master');
        $allStreams = json_decode($response['data']);
        foreach ($allStreams as $stream) {
            if(Stream::where('name', $stream->twitch)->exists()) {
                continue;
            }

            $this->getStreamDataFromTwitch($stream);
        }
    }

    public function getStreamDataFromTwitch($stream)
    {
        $additionalParams = [
            'delay' => 3000,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Client-ID' => 'y9i5ff8ov1scsxlf15d9oya5oqxjzi'
            ]
        ];
        $url = "https://api.twitch.tv/kraken/channels/" . $stream->twitch;
        $response = RemoteRequest::getRemoteContent($url, $additionalParams);
        try {
            $data = json_decode($response['data']);
            $this->storeNewStream($data, $stream->tags);
        } catch (\ErrorException $errorException) {
            var_dump($response);
        }
    }

    public function storeNewStream($stream, $tags)
    {
        $streamerData = [
            'name' => $stream->display_name,
            'twitch' => $stream->name,
            'title' => $stream->status,
            'language' => preg_replace('/(\-.*)/', '', $stream->language),
            'logo' => $stream->logo
        ];

        $newStream = Stream::create($streamerData);

        foreach ($tags as $tag) {
            $tag = StreamTag::firstOrCreate(['tag' => $tag], ['tag' => $tag]);
            $newStream->tags()->attach($tag->id);
        }

        $this->info('Streamer ' . $stream->display_name . ' stored');
    }
}
