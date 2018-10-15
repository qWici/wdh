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
        $response = RemoteRequest::getRemoteContent('https://api.github.com/repos/neculaesei/devstream.tv/contents/streams/');
        $allStreamFiles = json_decode($response['data']);
        foreach ($allStreamFiles as $stream) {
            $this->storeNewStream($stream->download_url);
        }
    }

    public function storeNewStream($JSON_URL)
    {
        $response = RemoteRequest::getRemoteContent($JSON_URL);
        $streamData = json_decode($response['data']);

        if(Stream::where('name', $streamData->name)->get()->count()) {
            return false;
        }

        $newStream = new Stream();
        $newStream->name = $streamData->name;
        $newStream->twitch = $streamData->twitch;
        $newStream->save();

        foreach ($streamData->tags as $tag) {
            $tag = StreamTag::firstOrCreate(['tag' => $tag], ['tag' => $tag]);
            $newStream->tags()->attach($tag->id);
        }
    }
}
