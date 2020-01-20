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
            $show->slug = str_slug($show->title);
            $show = json_decode(json_encode($show), true); // Convert stdClass to array

            $show = PodcastShow::updateOrCreate(["slug" => $show['slug']], $show);
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
        $imageURL = $show->image_url;
        $imagePath = "/images/shows/" . $show->slug . ".png";
        Image::make($imageURL)->encode('png', 75)->fit(350, 300)->save("public" . $imagePath);

        $show->image_url = $imagePath;
        $show->save();
    }
}
