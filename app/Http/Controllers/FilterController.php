<?php

namespace App\Http\Controllers;

use App\Models\{Article, Author, Stream, StreamTag, Channel, PodcastShow};
use Illuminate\Http\Request;
use Psy\Util\Str;

class FilterController extends Controller
{
    public function possible($type)
    {
        $filters = $this->getPossibleFilters($type);

        return response()->json($filters);
    }

    public function filter($type, Request $request)
    {
        $filters = $request->get('filters');
        switch ($type) {
            case 'articles':
                return $this->filterArticles($filters);
                break;
            case 'streams':
                return $this->getStreamFilters();
                break;
            case 'videos':
                return $this->getVideoFilters();
                break;
            case 'podcasts':
                return $this->getPodcastFilters();
                break;
            default:
                return [];
                break;
        }
        return response()->json([]);
    }

    private function getPossibleFilters($type)
    {
        switch ($type) {
            case 'articles':
                return $this->getArticleFilters();
                break;
            case 'streams':
                return $this->getStreamFilters();
                break;
            case 'videos':
                return $this->getVideoFilters();
                break;
            case 'podcasts':
                return $this->getPodcastFilters();
                break;
            default:
                return [];
                break;
        }
    }

    private function getArticleFilters()
    {
        $authors = [];
        $languages = [];
        foreach (Author::cursor() as $author) {
            $authors[] = [ "val" => $author->slug, "title" => $author->name ];
            if(isset($languages[$author->language])) continue;
            $languages[$author->language] = [ "val" => $author->language, "title" => strtoupper($author->language) ];
        }

        return [
            [ "title" => 'Language', "type" => 'lang', "values" => array_values($languages) ],
            [ "title" => 'Author', "type" => 'author', "values" => $authors ],
        ];
    }

    private function getStreamFilters()
    {
        $tags = [];
        $languages = [];

        foreach (Stream::cursor() as $stream) {
            if(!isset($languages[$stream->language])) {
                $languages[$stream->language] = [ "val" => $stream->language, "title" => strtoupper($stream->language) ];
            }
        }

        foreach (StreamTag::cursor() as $tag) {
            $tags[] = [ "val"=> $tag->slug, "title" => $tag->tag ];
        }

        return [
            [ "title" => 'Language', "type" => 'lang', "values" => array_values($languages) ],
            [ "title" => 'Tag', "type" => 'tag', "values" => $tags ],
        ];
    }

    private function getVideoFilters()
    {
        // @TODO: Add content language model etc. (id, type, slug, title & relationship to content)
        $channels = [];
        $languages = [];
        foreach (Channel::cursor() as $channel) {
            $channels[] = [ "val" => $channel->slug, "title" => $channel->title ];
        }

        return [
            [ "title" => 'Language', "type" => 'lang', "values" => array_values($languages) ],
            [ "title" => 'Author', "type" => 'author', "values" => $channels ],
        ];
    }

    private function getPodcastFilters()
    {
        $shows = [];
        $languages = [];
        foreach (PodcastShow::cursor() as $show) {
            $shows[] = [ "val" => $show->slug, "title" => $show->title ];
            if(isset($languages[$show->language])) continue;
            $languages[$show->language] = [ "val" => $show->language, "title" => strtoupper($show->language) ];
        }

        return [
            [ "title" => 'Language', "type" => 'lang', "values" => array_values($languages) ],
            [ "title" => 'Show', "type" => 'author', "values" => $shows ],
        ];
    }

    // @TODO: Recognize articles language for exist & feature
    private function filterArticles($filters)
    {
        foreach ($filters as $filter) {
            if ($filter->type === 'author') {
                $author = Author::where('slug', $filter->value)->firstOrFail();
                return Article::where('author_id', $author->id)->paginate(15);
            }

            if ($filter->type === 'lang') {
                $authors = Author::where('language', $filter->value)->get();
            }
        }
    }
}
