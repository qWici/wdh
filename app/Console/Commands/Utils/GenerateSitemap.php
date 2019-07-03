<?php

namespace App\Console\Commands\Utils;

use App\Models\Article;
use App\Models\Author;
use App\Models\Channel;
use App\Models\Podcast;
use App\Models\PodcastShow;
use App\Models\Stream;
use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\View\View;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto generate sitemaps';

    /**
     * All sitemap names
     * @var array
     */
    protected $sitemaps = [];

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
        $this->authorsSitemap();
        $this->contentSitemaps();
        $this->globalSitemap();

        \Log::info('Sitemap generated');
    }

    public function globalSitemap()
    {
        $sitemap = Sitemap::create();

        foreach ($this->sitemaps as $sitemapName) {
            $sitemap
                ->add(Url::create("/sitemap/${sitemapName}.xml")
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        }

        $sitemap->writeToFile(public_path("/sitemap.xml"));
    }

    public function authorsSitemap()
    {
        $authors = [
            'authors' => ['class' => Author::class, 'route' => 'articles'],
            'channels' => ['class' => Channel::class, 'route' => 'videos'],
            'podcasts-show' => ['class' => PodcastShow::class, 'route' => 'podcasts'],
        ];

        foreach ($authors as $title => $data) {
            $sitemap = Sitemap::create();
            $route = $data['route'];

            $data['class']::all()->each(function ($item) use ($sitemap, $route) {
                $sitemap->add(
                    Url::create("/${route}/{$item->slug}")
                        ->setPriority(0.8)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_NEVER)
                );
            });

            $sitemap->writeToFile(public_path("/sitemap/${title}.xml"));
            $this->sitemaps[] = $title;
        }
    }

    public function contentSitemaps()
    {
        $content = [
            'articles' => ['class' => Article::class, 'parentRelationship' => 'author'],
            'streams' => ['class' => Stream::class, 'parentRelationship' => null],
            'videos' => ['class' => Video::class, 'parentRelationship' => 'channel'],
            'podcasts' => ['class' => Podcast::class, 'parentRelationship' => 'show']
        ];

        foreach ($content as $title => $data) {
            $sitemap = Sitemap::create();
            $parent = $data['parentRelationship'];

            $items = empty($parent)
                ? $data['class']::all()
                : $data['class']::with($parent)->get();

            $items->each(function ($item) use ($sitemap, $title, $parent) {
                $url = empty($parent)
                    ? "/${title}/{$item->twitch}"
                    : "/${title}/{$item->$parent->slug}/{$item->slug}";

                $sitemap->add(
                    Url::create($url)
                        ->setPriority(0.9)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_NEVER)
                );
            });

            $sitemap->writeToFile(public_path("/sitemap/${title}.xml"));
            $this->sitemaps[] = $title;
        }
    }
}
