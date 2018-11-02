<?php

namespace App\Console\Commands\Articles;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Console\Command;
use Image;

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
                if(Article::where(['slug' => str_slug($article['title']), 'author_id' => $author->id])->exists()) {
                    continue;
                }
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

            if(count($node->getElementsByTagName('encoded')) > 0) {
                $description = $node->getElementsByTagName('encoded')->item(0)->nodeValue;
            } elseif(count($node->getElementsByTagName('description')) > 0) {
                $description = $node->getElementsByTagName('description')->item(0)->nodeValue;
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
        $newArticle->description = $this->prepareDescription($article['description']);
        $newArticle->author_id = $authorID;
        $newArticle->date = empty($article['pubDate'])
            ? date('Y-m-d-H:i:s', time())
            : date("Y-m-d H:i:s", strtotime($article['pubDate']));

        $newArticle->image_src = $this->getImageFromDescription($article['description'], $site_url, $article['title']);

        try{
            $newArticle->save();
        } catch (\Exception $exception) {
            var_dump($exception);
        }
    }

    public function getImageFromDescription($description, $site_url, $title)
    {
        if(empty($description)) { return null; }

        $imageSRC = '';
        $re = '/(<img.*?src=")([^"]*?(?:png|jpg|jpeg|gif|png|svg))/m';
        preg_match_all($re, $description, $matches, PREG_SET_ORDER, 0);
        if(! empty($matches) && !empty($matches[0][2])) {
            $imageSRC = $matches[0][2];
        }

        if(empty($imageSRC)) {
            return $this->generateImage($title);
        }

        if(strpos($imageSRC, 'http') !== false) {
            return str_replace('"', "", $imageSRC);
        }

        return $site_url . str_replace('"', "", $imageSRC);
    }

    public function prepareDescription($description)
    {
        $description = str_replace('><', '> <', $description);
        $preparedDescription = mb_convert_encoding(htmlspecialchars_decode(strip_tags($description)), "UTF-8");
        $descriptionSlices = empty($description) ?: substr($preparedDescription,0,500);

        return trim($descriptionSlices);
    }

    public function generateImage($title)
    {
        $img = Image::make('public/img/default_item_bg.jpeg');

        $words = explode(' ', $title);
        $phrases = array_chunk($words, 4);
        $startPosY = 525 - ((count($phrases) - 1) * 72);

        foreach ($phrases as $counter => $phrase) {
            $text = implode($phrase, " ");

            $posY = $startPosY + ($counter * 115);

            $img->text($text, 800, $posY, function($font) {
                $font->file('public/fonts/Montserrat-Bold.ttf');
                $font->size(72);
                $font->color('#2B274D');
                $font->align('center');
                $font->valign('middle');
            });
        }


        $imagePath = "/images/articles/" . str_slug($title) . ".jpg";
        $img->encode('jpg', 75)->save("public" . $imagePath);

        return $imagePath;
    }
}