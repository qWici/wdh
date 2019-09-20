<?php

namespace App\Console\Commands\Videos;

use App\Models\Video;
use Carbon\Carbon;
use Youtube;
use Illuminate\Console\Command;

class UpdateYoutubeInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:update {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update info for video';

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
        $all = $this->option('all');
        $videos = [];

        if ($all) {
            $videos = Video::where('updated_at', '<', Carbon::now()->subDays(30)->format('Y-m-d'))->get();
        } else {
            $videos = Video::whereDay('published_at', Carbon::now()->day)->where('updated_at', '<', Carbon::now()->subDays(30)->format('Y-m-d'))->get();
        }

        foreach ($videos as $video) {
            $this->updateVideoInfo($video);
        }
    }

    public function updateVideoInfo(Video $video)
    {
        $newInfo = Youtube::getVideoInfo($video->youtube_id);
        $video->title = $newInfo->snippet->title;
        $video->slug = str_slug($newInfo->snippet->title);
        $video->description = html_entity_decode($newInfo->snippet->description);
        $video->updated_at = Carbon::now()->toDateTimeString();
        $video->update();
    }
}
