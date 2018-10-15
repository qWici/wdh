<?php

namespace App\Console\Commands;

use App\Helpers\RemoteRequest;
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

    protected $streamFilesList = [];

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
            $this->streamFilesList[] = $stream->download_url;
        }
        var_dump($this->streamFilesList);
    }
}
