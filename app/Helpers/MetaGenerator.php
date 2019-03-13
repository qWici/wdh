<?php

namespace App\Helpers;

use App\Models\Article;
use App\Models\Author;
use App\Models\Channel;
use App\Models\Podcast;
use App\Models\PodcastShow;
use App\Models\Stream;
use App\Models\Video;
use Spatie\SchemaOrg\Schema;

class MetaGenerator
{
    private static $url;

    public static function generate($url)
    {
        self::$url = $url;
        $params = explode('/', substr(self::$url,1));

        // Home Page
        if ($params[0] === '') {
            return self::home();
        }

        switch (count($params)) {
            case 1:
                return self::type($params[0]); // articles
            case 2:
                return self::type($params[0], $params[1]); // articles/author
            case 3:
                return self::type($params[0], $params[1], $params[2]); // articles/author/article
        }
    }

    private static function breadcrumbs($links)
    {
        $breadcrumbs = [];
        foreach ($links as $index => $link) {
            $breadcrumbs[] = Schema::listItem()->position($index + 1)->name($link["name"])->item($link['url']);
        }

        return $breadcrumbs;
    }

    private static function home()
    {
        $title = "Aggregator of web development content";
        $description = "It is an aggregator of articles, videos, podcasts, and streams about web development";

        return [
            "title" => $title . " | WebDevHub",
            "description" => $description,
            "og:title" => $title,
            "og:site_name" => "WebDevHub",
            "og:type" => "website",
            "og:url" => config("app.url"),
            "og:image" => config("app.url") . "img/mockup.png",
            "og:description" => $description,
            "twitter:card" => "summary_large_image",
            "twitter:site" => config("app.url"),
            "twitter:title" => $title,
            "twitter:description" => $description,
            "twitter:image:src" => config("app.url") . "img/mockup.png",
            "breadcrumbs" => self::breadcrumbs([["name" => "Home", "url" => config("app.url")]])
        ];
    }

    private static function type($type, $author = null, $post = null)
    {
        switch ($type) {
            case 'streams':
                return self::streams($author);
            case 'articles':
                return self::articles($author, $post);
            case 'videos':
                return self::videos($author, $post);
            case 'podcasts':
                return self::podcasts($author, $post);
            default:
                return [];
        }
    }

    private static function streams($stream = null)
    {
        $title = "Web development live streams";
        $description = "Live streams about development websites";

        if ($stream === 'tag') {
            return [
                "title" => $title . " | WebDevHub",
                "description" => $description,
                "og:title" => $title,
                "og:site_name" => "WebDevHub",
                "og:type" => "website",
                "og:url" => config("app.url") . substr(self::$url,1),
                "og:image" => config("app.url") . "img/mockup.png",
                "og:description" => $description,
                "twitter:card" => "summary_large_image",
                "twitter:site" => config("app.url") . substr(self::$url,1),
                "twitter:title" => $title,
                "twitter:description" => $description,
                "twitter:image:src" => config("app.url") . "img/mockup.png",
                "breadcrumbs" => self::breadcrumbs([
                    ["name" => "Home", "url" => config("app.url")],
                    ["name" => "Streams", "url" => config("app.url") . 'streams']
                ])
            ];
        }

        if (isset($stream) && $stream !== "undefined") {
            $streamData = Stream::where('twitch', $stream)->first();
            $twitch = $streamData->twitch;
            $title = $twitch . "live streams";
            $description = $streamData->title;

            return [
                "title" => $title . " | WebDevHub",
                "description" => $description,
                "og:title" => $title,
                "og:site_name" => "WebDevHub",
                "og:type" => "website",
                "og:url" => config("app.url") . substr(self::$url,1),
                "og:image" => config("app.url") . "img/mockup.png",
                "og:description" => $description,
                "twitter:card" => "summary_large_image",
                "twitter:site" => config("app.url") . substr(self::$url,1),
                "twitter:title" => $title,
                "twitter:description" => $description,
                "twitter:image:src" => config("app.url") . "img/mockup.png",
                "breadcrumbs" => self::breadcrumbs([
                    ["name" => "Home", "url" => config("app.url")],
                    ["name" => "Streams", "url" => config("app.url") . 'streams'],
                    ["name" => $twitch, "url" => config("app.url") . 'streams/' . $twitch],
                ])
            ];
        }

        return [
            "title" => $title . " | WebDevHub",
            "description" => $description,
            "og:title" => $title,
            "og:site_name" => "WebDevHub",
            "og:type" => "website",
            "og:url" => config("app.url") . substr(self::$url,1),
            "og:image" => config("app.url") . "img/mockup.png",
            "og:description" => $description,
            "twitter:card" => "summary_large_image",
            "twitter:site" => config("app.url") . substr(self::$url,1),
            "twitter:title" => $title,
            "twitter:description" => $description,
            "twitter:image:src" => config("app.url") . "img/mockup.png",
            "breadcrumbs" => self::breadcrumbs([
                ["name" => "Home", "url" => config("app.url")],
                ["name" => "Streams", "url" => config("app.url") . 'streams']
            ])
        ];
    }

    private static function articles($author = null, $article = null)
    {
        $title = "Web development articles";
        $description = "Articles about development websites";

        if(isset($article) && $article !== 'undefined') {
            $articleData = Article::where('slug', $article)->with('author')->first();

            $title = $articleData->title;
            $description = self::substrwords($articleData->description, 155);
            $image = strpos($articleData->image_src, 'http') !== false
                ? $articleData->image_src
                : config("app.url") . substr($articleData->image_src,1);

            return [
                "title" => $title . " | WebDevHub",
                "description" => $description,
                "og:title" => $title,
                "og:site_name" => "WebDevHub",
                "og:type" => "website",
                "og:url" => config("app.url") . substr(self::$url,1),
                "og:image" => $image,
                "og:description" => $description,
                "twitter:card" => "summary_large_image",
                "twitter:site" => config("app.url") . substr(self::$url,1),
                "twitter:title" => $title,
                "twitter:description" => $description,
                "twitter:image:src" => $image,
                "breadcrumbs" => self::breadcrumbs([
                    ["name" => "Home", "url" => config("app.url")],
                    ["name" => "Articles", "url" => config("app.url") . 'articles'],
                    [
                        "name" => $articleData->author->name,
                        "url" => config("app.url") . 'articles/' . $articleData->author->slug
                    ],
                    [
                        "name" => $articleData->title,
                        "url" => config("app.url") . 'articles/' . $articleData->author->slug . "/" . $articleData->slug
                    ]
                ])
            ];
        }

        if(isset($author)) {
            $articleAuthor = Author::where('slug', $author)->first();

            $title = "Articles by " . $articleAuthor->name;
            $description = "Articles about development websites by " . $articleAuthor->name;

            return [
                "title" => $title . " | WebDevHub",
                "description" => $description,
                "og:title" => $title,
                "og:site_name" => "WebDevHub",
                "og:type" => "website",
                "og:url" => config("app.url") . substr(self::$url,1),
                "og:image" => config("app.url") . "img/mockup.png",
                "og:description" => $description,
                "twitter:card" => "summary_large_image",
                "twitter:site" => config("app.url") . substr(self::$url,1),
                "twitter:title" => $title,
                "twitter:description" => $description,
                "twitter:image:src" => config("app.url") . "img/mockup.png",
                "breadcrumbs" => self::breadcrumbs([
                    ["name" => "Home", "url" => config("app.url")],
                    ["name" => "Articles", "url" => config("app.url") . 'articles'],
                    [
                        "name" => $articleAuthor->name,
                        "url" => config("app.url") . 'articles/' . $articleAuthor->slug
                    ]
                ])
            ];
        }

        return [
            "title" => $title . " | WebDevHub",
            "description" => $description,
            "og:title" => $title,
            "og:site_name" => "WebDevHub",
            "og:type" => "website",
            "og:url" => config("app.url") . substr(self::$url,1),
            "og:image" => config("app.url") . "img/mockup.png",
            "og:description" => $description,
            "twitter:card" => "summary_large_image",
            "twitter:site" => config("app.url") . substr(self::$url,1),
            "twitter:title" => $title,
            "twitter:description" => $description,
            "twitter:image:src" => config("app.url") . "img/mockup.png",
            "breadcrumbs" => self::breadcrumbs([
                ["name" => "Home", "url" => config("app.url")],
                ["name" => "Articles", "url" => config("app.url") . 'articles']
            ])
        ];
    }

    private static function videos($channel = null, $video = null)
    {
        $title = "Web development videos";
        $description = "Videos about development websites";

        if (isset($video) && $video !== "undefined") {
            $videoData = Video::where('slug', $video)->with('channel')->first();
            $title = $videoData->title;
            $description = self::substrwords($videoData->description, 155);
            $image = config('app.url') . substr($videoData->image_src,1);

            return [
                "title" => $title . " | WebDevHub",
                "description" => $description,
                "og:title" => $title,
                "og:site_name" => "WebDevHub",
                "og:type" => "website",
                "og:url" => config("app.url") . substr(self::$url,1),
                "og:image" => $image,
                "og:description" => $description,
                "twitter:card" => "summary_large_image",
                "twitter:site" => config("app.url") . substr(self::$url,1),
                "twitter:title" => $title,
                "twitter:description" => $description,
                "twitter:image:src" => $image,
                "breadcrumbs" => self::breadcrumbs([
                    ["name" => "Home", "url" => config("app.url")],
                    ["name" => "Videos", "url" => config("app.url") . 'videos'],
                    [
                        "name" => $videoData->channel->title,
                        "url" => config("app.url") . 'videos/' . $videoData->channel->slug
                    ],
                    [
                        "name" => $videoData->title,
                        "url" => config("app.url") . 'videos/' . $videoData->channel->slug . "/" . $videoData->slug
                    ]
                ])
            ];
        }

        if (isset($channel)) {
            $channelData = Channel::where('slug', $channel)->first();
            $title = "Videos by " . $channelData->title;
            $description = self::substrwords($channelData->description, 155);
            $image = config('app.url') . substr($channelData->image_src,1);

            return [
                "title" => $title . " | WebDevHub",
                "description" => $description,
                "og:title" => $title,
                "og:site_name" => "WebDevHub",
                "og:type" => "website",
                "og:url" => config("app.url") . substr(self::$url,1),
                "og:image" => $image,
                "og:description" => $description,
                "twitter:card" => "summary_large_image",
                "twitter:site" => config("app.url") . substr(self::$url,1),
                "twitter:title" => $title,
                "twitter:description" => $description,
                "twitter:image:src" => $image,
                "breadcrumbs" => self::breadcrumbs([
                    ["name" => "Home", "url" => config("app.url")],
                    ["name" => "Videos", "url" => config("app.url") . 'videos'],
                    [
                        "name" => $channelData->title,
                        "url" => config("app.url") . 'videos/' . $channelData->slug
                    ]
                ])
            ];
        }

        return [
            "title" => $title . " | WebDevHub",
            "description" => $description,
            "og:title" => $title,
            "og:site_name" => "WebDevHub",
            "og:type" => "website",
            "og:url" => config("app.url") . substr(self::$url,1),
            "og:image" => config("app.url") . "img/mockup.png",
            "og:description" => $description,
            "twitter:card" => "summary_large_image",
            "twitter:site" => config("app.url") . substr(self::$url,1),
            "twitter:title" => $title,
            "twitter:description" => $description,
            "twitter:image:src" => config("app.url") . "img/mockup.png",
            "breadcrumbs" => self::breadcrumbs([
                ["name" => "Home", "url" => config("app.url")],
                ["name" => "Videos", "url" => config("app.url") . 'videos']
            ])
        ];
    }

    private static function podcasts($show = null, $podcast = null)
    {
        $title = "Web development podcasts";
        $description = "Podcasts about development websites";

        if (isset($podcast) && $podcast !== "undefined") {
            $podcastData = Podcast::where('slug', $podcast)->with('show')->first();
            $title = $podcastData->title;
            $description = self::substrwords($podcastData->description, 155);

            return [
                "title" => $title . " | WebDevHub",
                "description" => $description,
                "og:title" => $title,
                "og:site_name" => "WebDevHub",
                "og:type" => "website",
                "og:url" => config("app.url") . substr(self::$url,1),
                "og:image" => config("app.url") . "img/mockup.png",
                "og:description" => $description,
                "twitter:card" => "summary_large_image",
                "twitter:site" => config("app.url") . substr(self::$url,1),
                "twitter:title" => $title,
                "twitter:description" => $description,
                "twitter:image:src" => config("app.url") . "img/mockup.png",
                "breadcrumbs" => self::breadcrumbs([
                    ["name" => "Home", "url" => config("app.url")],
                    ["name" => "Podcasts", "url" => config("app.url") . 'podcasts'],
                    [
                        "name" => $podcastData->show->title,
                        "url" => config("app.url") . 'podcasts/' . $podcastData->show->slug
                    ],
                    [
                        "name" => $podcastData->title,
                        "url" => config("app.url") . 'podcasts/' . $podcastData->show->slug . "/" . $podcastData->slug
                    ]
                ])
            ];
        }

        if (isset($show)) {
            $showData = PodcastShow::where('slug', $show)->first();
            $title = "Web development podcasts by " . $showData->title;
            $description = self::substrwords($showData->description, 155);
            $image = config('app.url') . substr($showData->image_url,1);

            return [
                "title" => $title . " | WebDevHub",
                "description" => $description,
                "og:title" => $title,
                "og:site_name" => "WebDevHub",
                "og:type" => "website",
                "og:url" => config("app.url") . substr(self::$url,1),
                "og:image" => $image,
                "og:description" => $description,
                "twitter:card" => "summary_large_image",
                "twitter:site" => config("app.url") . substr(self::$url,1),
                "twitter:title" => $title,
                "twitter:description" => $description,
                "twitter:image:src" => $image,
                "breadcrumbs" => self::breadcrumbs([
                    ["name" => "Home", "url" => config("app.url")],
                    ["name" => "Podcasts", "url" => config("app.url") . 'podcasts'],
                    [
                        "name" => $showData->title,
                        "url" => config("app.url") . 'podcasts/' . $showData->slug
                    ]
                ])
            ];
        }

        return [
            "title" => $title . " | WebDevHub",
            "description" => $description,
            "og:title" => $title,
            "og:site_name" => "WebDevHub",
            "og:type" => "website",
            "og:url" => config("app.url") . substr(self::$url,1),
            "og:image" => config("app.url") . "img/mockup.png",
            "og:description" => $description,
            "twitter:card" => "summary_large_image",
            "twitter:site" => config("app.url") . substr(self::$url,1),
            "twitter:title" => $title,
            "twitter:description" => $description,
            "twitter:image:src" => config("app.url") . "img/mockup.png",
            "breadcrumbs" => self::breadcrumbs([
                ["name" => "Home", "url" => config("app.url")],
                ["name" => "Podcasts", "url" => config("app.url") . 'podcasts']
            ])
        ];
    }

    private static function substrwords($text, $maxchar, $end='...') {
        if (strlen($text) < 1) { return ''; }

        if (strlen($text) > $maxchar || $text == '') {
            $words = preg_split('/\s/', $text);
            $output = '';
            $i = 0;
            while (1) {
                $length = strlen($output)+strlen($words[$i]);
                if ($length > $maxchar) {
                    break;
                }
                else {
                    $output .= " " . $words[$i];
                    ++$i;
                }
            }
            $output .= $end;
        }
        else {
            $output = $text;
        }
        return $output;
    }
}
