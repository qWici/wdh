<?php

namespace App\Console\Commands\Podcasts;

use App\Models\Podcast;
use App\Models\PodcastShow;
use Illuminate\Console\Command;
use Laravie\Parser\InvalidContentException;
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

        \Log::info("Podcasts Updated");
    }

    public function getPodcasts($url, $showID)
    {
        try {
            $xml = XmlParser::load($url);
        } catch (InvalidContentException $exception) {
            $xml = XmlParser::extract($url);
        }

        $items = $xml->rebase('channel')->parse([
            'items'  => ['uses' => 'item[title,pubDate,enclosure::url]'],
            'media' => ['uses' => 'item/itunes[summary,duration]']
        ]);

        $podcasts = [];
        foreach (array_slice($items['items'],0, 20) as $i => $item) {
            $podcasts[] = [
                'podcast_show_id' => $showID,
                'title' => $item['title'],
                'slug' => str_slug($item['title']),
                'description' => html_entity_decode($items['media'][$i]['summary']),
                'duration' => $items['media'][$i]['duration'],
                'published_at' => date("Y-m-d H:i:s", strtotime($item['pubDate'])),
                'audio_url' => $item['enclosure::url'],
            ];
        }

        return $podcasts;
    }

    public function storePodcasts($podcasts)
    {
        foreach ($podcasts as $podcast) {
            if(Podcast::where(['slug' => $podcast['slug'], 'podcast_show_id' => $podcast['podcast_show_id']])->exists()) {
                continue;
            }

            Podcast::create($podcast);
            Podcast::where('slug', $podcast['slug'])->first()->addContent($podcast['published_at']);
        }
    }
}
