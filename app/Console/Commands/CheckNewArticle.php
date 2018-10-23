<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Console\Command;
use Orchestra\Parser\Xml\Facade as XmlParser;

class CheckNewArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if exist new articles';

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
        foreach(Author::cursor() as $author) {
            $articles = $this->getArticles($author->feed_url);
            $articles = array_slice($articles, 0, 5);
            foreach ($articles as $article) {
                $this->storeArticle($article, $author->id, $author->site_url);
            }
        }
    }

    public function getArticles($url)
    {
        $rss = new \DOMDocument();
        $rss->load($url);
        $feed = [];
        foreach ($rss->getElementsByTagName('item') as $node) {
            $date = null;

            if(count($node->getElementsByTagName('pubDate')) > 0) {
                $date = $node->getElementsByTagName('pubDate')->item(0)->nodeValue;
            } elseif(count($node->getElementsByTagName('date')) > 0) {
                $date = $node->getElementsByTagName('date')->item(0)->nodeValue;
            }

            $description = null;

            if(count($node->getElementsByTagName('description')) > 0) {
                $description = $node->getElementsByTagName('description')->item(0)->nodeValue;
            } elseif(count($node->getElementsByTagName('encoded')) > 0) {
                $description = $node->getElementsByTagName('encoded')->item(0)->nodeValue;
            }

            $item = [
                'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                'link' => $node->getElementsByTagName('guid')->item(0)->nodeValue,
                'pubDate' => $date,
                'description' => $description,
            ];
            array_push($feed, $item);
        }
        return $feed;
    }

    public function storeArticle($article, $authorID, $site_url)
    {
        $newArticle = new Article();
        $newArticle->title = $article['title'];
        $newArticle->slug = str_slug($article['title']);
        $newArticle->link = $article['link'];

        $descriptionSlices = empty($article['description']) ?: substr(strip_tags($article['description']),0,500);
        $newArticle->description = $descriptionSlices;

        $newArticle->author_id = $authorID;
        $newArticle->date = empty($article['pubDate'])
            ? date('Y-m-d-H:i:s', time())
            : date("Y-m-d H:i:s", strtotime($article['pubDate']));

        $newArticle->image_src = $this->getImageFromDescription($article['description'], $site_url);

        $newArticle->save();
    }

    public function getImageFromDescription($description, $site_url)
    {
        if(empty($description)) { return null; }

        $imageSRC = '';
        $re = '/src=\"(.*)\" /mU';
        preg_match_all($re, $description, $matches, PREG_SET_ORDER, 0);
        if(! empty($matches) && !empty($matches[0][1])) {
            $imageSRC = $matches[0][1];
        }

        if(strpos($imageSRC, 'http') !== false) {
            return $imageSRC;
        }

        return $site_url . $imageSRC;
    }
}
