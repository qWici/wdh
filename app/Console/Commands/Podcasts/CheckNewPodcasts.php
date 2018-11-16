<?php

namespace App\Console\Commands\Podcasts;

use App\Models\Podcast;
use App\Models\PodcastShow;
use Illuminate\Console\Command;
use Orchestra\Parser\Xml\Facade as XmlParser;

class CheckNewPodcasts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:podcasts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check new podcasts';

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
        foreach (PodcastShow::cursor() as $show) {
            $podcasts = $this->getPodcasts($show->feed_url, $show->id);
            $this->storePodcasts($podcasts);
        }
    }

    public function getPodcasts($url, $showID)
    {
        $xml = XmlParser::load($url);

        $items = $xml->rebase('channel')->parse([
            'items'  => ['uses' => 'item[title,pubDate,enclosure::url]'],
            'media' => ['uses' => 'item/itunes[summary,duration]']
        ]);

        $podcasts = [];
        for($i = 0; $i < 20; $i++) {
            $podcasts[] = [
                'podcast_shows_id' => $showID,
                'title' => $items['items'][$i]['title'],
                'slug' => str_slug($items['items'][$i]['title']),
                'description' => $items['media'][$i]['summary'],
                'duration' => $items['media'][$i]['duration'],
                'published_at' => date("Y-m-d H:i:s", strtotime($items['items'][$i]['pubDate'])),
                'audio_url' => $items['items'][$i]['enclosure::url'],
            ];
        }

        return $podcasts;
    }

    public function storePodcasts($podcasts)
    {
        foreach ($podcasts as $podcast) {
            if(Podcast::where(['slug' => $podcast['slug'], 'podcast_shows_id' => $podcast['podcast_shows_id']])->exists()) {
                continue;
            }

            Podcast::create($podcast);
            $this->info("Podcast \"" . $podcast['title'] . "\" stored");
        }
    }
}
