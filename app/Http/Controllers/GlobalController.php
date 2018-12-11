<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Podcast;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GlobalController extends Controller
{
    public function getLast(Request $request) : JsonResponse
    {
        $page = $request->get('page');

        if ($page <= 3) {
            $cachePageKey = 'last_' . $request->get('page');

            $last = Cache::remember($cachePageKey, 60, function () {
                return $this->getLatestSortedItems();
            });
        } else {
            $last = $this->getLatestSortedItems();
        }

        $result = $last->chunk(9)->toArray();

        return response()->json(array_values($result[$request->get('page')]));
    }

    private function getLatestSortedItems()
    {
        $articles = Article::orderBy('date', 'desc')
            ->with('author')
            ->get()
            ->take(25);

        $podcasts = Podcast::orderBy('published_at', 'desc')
            ->with('show')
            ->get()
            ->take(25);

        $videos = Video::orderBy('published_at', 'desc')
            ->with('channel')
            ->get()
            ->take(25);

        return $articles->concat($podcasts)->concat($videos)->sortBy(function ($item) {
            if (isset($item['published_at'])) {
                return -strtotime($item->published_at);
            }

            return -strtotime($item->date);
        });
    }
}
