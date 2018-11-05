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
            $videoList = Youtube::listChannelVideos($channel->youtube_id, 10);
            $this->check($videoList, $channel->id);
        }
    }

    public function check(array $videoList, string $channelID)
    {
        foreach ($videoList as $video) {
            if(Video::where('youtube_id', $video->id->videoId)->exists()) {
                continue;
            }

            $this->store($video, $channelID);
        }
    }

    public function store($video, $channelID)
    {
        $newVideo = new Video();
        $newVideo->channel_id = $channelID;
        $newVideo->youtube_id = $video->id->videoId;
        $newVideo->title = $video->snippet->title;
        $newVideo->slug = str_slug($video->snippet->title);
        $newVideo->description = $video->snippet->description;

        $thumbnail = $this->storeVideoThumbnail(
            $video->snippet->thumbnails->high->url,
            str_slug($video->snippet->title)
        );

        $newVideo->image_src = $thumbnail;
        $newVideo->published_at = $video->snippet->publishedAt;
        $newVideo->save();

        $this->info("Video \"" . $newVideo->title . "\" stored");
    }

    public function storeVideoThumbnail(string $url, string $slug)
    {
        $imagePath = "/images/videos/" . $slug . ".webp";
        Image::make($url)->encode('webp', 75)->save("public" . $imagePath);
        return $imagePath;
    }
}
