<?php

namespace App\Console\Commands\Parsers;

use App\Helpers\ParseResource;
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

    private $twitchNicknames = [];

    private $streamsWithId = [];

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
        $streamers = collect(ParseResource::getData('streamers'));

        foreach ($streamers as $stream) {
            if(Stream::where('twitch', $stream->twitch)->exists()) {
                continue;
            }

            $this->twitchNicknames[] = $stream->twitch;
        }

        $twitchBaseData = $this->collectTwitchIds();

        foreach ($twitchBaseData as $baseDatum) {
            $defaultData = $streamers->firstWhere('twitch', $baseDatum->login);
            if (empty($defaultData)) {
                $defaultData = $streamers->firstWhere('twitch', $baseDatum->display_name);
            }

            $defaultData->twitch_id = $baseDatum->id;

            $this->streamsWithId[] = $defaultData;
        }

        foreach ($this->streamsWithId as $stream) {
            $this->getStreamDataFromTwitch($stream);
        }
    }

    public function collectTwitchIds()
    {
        $additionalParams = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Client-ID' => env('TWITCH_CLIENT_ID'),
            ]
        ];

        $query = implode('&login=', $this->twitchNicknames);

        $url = 'https://api.twitch.tv/helix/users?login=' . $query;
        $data = [];
        try {
            $response = RemoteRequest::getRemoteContent($url, $additionalParams);
            $data = json_decode($response['data']);
        } catch (\ErrorException $e) {
            $this->error("Error when try to get twitch ids");
        }

        if (count($data->data) > 0) {
            return $data->data;
        }

        return [];
    }

    /**
     * Get data from Twitch
     *
     * @param $stream
     */
    public function getStreamDataFromTwitch($stream)
    {
        $additionalParams = [
            'headers' => [
                'Accept' => 'application/vnd.twitchtv.v5+json',
                'Client-ID' => env('TWITCH_CLIENT_ID')
            ]
        ];

        $data = [];
        try {
            $url = "https://api.twitch.tv/kraken/channels/" . $stream->twitch_id;
            $response = RemoteRequest::getRemoteContent($url, $additionalParams);

            $data = json_decode($response['data']);
        } catch (\ErrorException $e) {
            $this->error("Error get Twitch full data | Twitch nickname: " . $stream->twitch_id);
            $this->error($e->getMessage());
        }

        if (! empty($data)) {
            $this->storeNewStream($data, $stream->tags);
        }
    }

    /**
     * Store new streamer
     *
     * @param $stream
     * @param $tags
     */
    public function storeNewStream($stream, $tags)
    {
        $streamerData = [
            'name' => $stream->display_name,
            'twitch' => $stream->name,
            'twitch_id' => $stream->_id,
            'title' => $stream->status,
            'language' => preg_replace('/(\-.*)/', '', $stream->language),
            'logo' => $stream->logo
        ];

        $newStream = Stream::create($streamerData);
        \Artisan::call('twitch:subscribe', ['twitch_id' => $stream->_id]);
        $this->info('New streamer | ' . $newStream->name);

        foreach ($tags as $tag) {
            $tag = StreamTag::firstOrCreate(['tag' => $tag], ['tag' => $tag]);
            $newStream->tags()->attach($tag->id);
        }
    }
}
