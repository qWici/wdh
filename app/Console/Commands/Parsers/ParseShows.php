<?php

namespace App\Console\Commands\Parsers;

use App\Helpers\ParseResource;
use App\Models\PodcastShow;
use Illuminate\Console\Command;
use Image;

class ParseShows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:shows';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse shows';

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
        $shows = ParseResource::getData('podcasts');
        foreach ($shows as $show) {
            if(PodcastShow::where('slug', str_slug($show->title))->exists()) {
                continue;
            }

            $this->storeShow($show);
        }
    }

    /**
     * Store show
     *
     * @param $show
     */
    public function storeShow($show)
    {
        $show->slug = str_slug($show->title);

        $imageURL = $show->image_url;
        $imagePath = "/images/shows/" . $show->slug . ".png";
        Image::make($imageURL)->encode('png', 75)->fit(350, 300)->save("public" . $imagePath);

        $show->image_url = $imagePath;
        PodcastShow::create((array) $show);
    }
}
