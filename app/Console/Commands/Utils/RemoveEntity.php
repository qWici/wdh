<?php

namespace App\Console\Commands\Utils;

use App\Models\Article;
use App\Models\Podcast;
use App\Models\Video;
use Illuminate\Console\Command;

class RemoveEntity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:entity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove one or few entity from DB';

    /**
     * The type of entity
     *
     * @var string
     */
    private $type;

    /**
     * Array of entity ids
     *
     * @var array
    */
    private $ids;

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
        $this->type = $this->choice('Entity type', ['article', 'video', 'podcast']);
        $ids = $this->ask('Entity IDs. For separate ID - use space');
        $this->ids = explode(" ", $ids);

        if ($this->confirm('Are you sure?')) {
            $this->info('Start to remove entities');
            $this->removeEntities();
            $this->info('All entities are removed');
        }
    }

    private function removeEntities()
    {
        switch($this->type) {
            case 'article':
                $this->removeArticle();
                break;
            case 'video':
                $this->removeVideo();
                break;
            case 'podcast':
                $this->removePodcast();
                break;
            default:
                $this->error('Type is not defined');
                break;
        }
    }

    private function removeArticle()
    {
        foreach($this->ids as $id) {
            $this->info("Process ID: ${id}");

            $article = Article::where('id', $id)->firstOrFail();
            $article->removeContent();
            $this->info('Removed from contentable');

            $article->delete();
            $this->info('Article removed');
        }
    }

    private function removeVideo()
    {
        foreach($this->ids as $id) {
            $this->info("Process ID: ${id}");

            $video = Video::where('id', $id)->firstOrFail();
            $video->removeContent();
            $this->info('Removed from contentable');

            $video->delete();
            $this->info('Video removed');
        }
    }

    private function removePodcast()
    {
        foreach($this->ids as $id) {
            $this->info("Process ID: ${id}");

            $podcast = Podcast::where('id', $id)->firstOrFail();
            $podcast->removeContent();
            $this->info('Removed from contentable');

            $podcast->delete();
            $this->info('Podcast removed');
        }
    }
}
