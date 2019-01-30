<?php

namespace App\Console\Commands\Videos;

use App\Models\Video;
use Youtube;
use Image;
use App\Models\Channel;
use Illuminate\Console\Command;

class CheckNew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and store new videos';

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
        foreach (Channel::cursor() as $channel) {
            $videoList = Youtube::listChannelVideos($channel->youtube_id, 10, 'date');
            $this->check($videoList, $channel->id);
        }

        \Log::info("Videos Updated");
    }

    public function check(array $videoList, string $channelID)
    {
        foreach ($videoList as $video) {
            if(Video::where('youtube_id', $video->id->videoId)->exists()) {
                continue;
            }

            $this->store($video->id->videoId, $channelID);
        }
    }

    public function store($videoID, $channelID)
    {
        $video = Youtube::getVideoInfo($videoID);

        $newVideo = new Video();
        $newVideo->channel_id = $channelID;
        $newVideo->youtube_id = $videoID;
        $newVideo->title = $video->snippet->title;
        $newVideo->slug = str_slug($video->snippet->title);
        $newVideo->description = $video->snippet->description;

        $thumbnail = $this->storeVideoThumbnail(
            $video->snippet->thumbnails->high->url,
            str_slug($video->snippet->title)
        );

        $newVideo->lang = $this->checkAndPrepareLang($video);
        $newVideo->image_src = $thumbnail;
        $newVideo->published_at = date("Y-m-d H:i:s", strtotime($video->snippet->publishedAt));
        $newVideo->save();

        $newVideo->addContent($newVideo->published_at);
    }

    public function storeVideoThumbnail(string $url, string $slug)
    {
        $imagePath = "/images/videos/" . $slug . ".png";
        Image::make($url)->encode('png', 75)->fit(1050, 500)->save("public" . $imagePath);
        return $imagePath;
    }

    public function checkAndPrepareLang($video)
    {
        if(! property_exists($video->snippet, 'defaultAudioLanguage')) {
            return null;
        }

        $currentLang = $video->snippet->defaultAudioLanguage;
        if(strlen($currentLang) > 2) {
            return substr($currentLang, 0, -3);
        }

        return $currentLang;
    }
}
