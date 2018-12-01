<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Podcast;
use App\Models\Stream;
use App\Models\Video;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request) {
        $query = $request->get('q');

        $articles = Article::where('title', 'like', "%${query}%")
            ->with('author')
            ->take(3)
            ->get();

        $videos = Video::where('title', 'like', "%${query}%")
            ->with('channel')
            ->take(3)
            ->get();

        $podcasts = Podcast::where('title', 'like', "%${query}%")
            ->with('show')
            ->take(3)
            ->get();

        $streams = Stream::where('title', 'like', "%${query}%")
            ->online()
            ->take(3)
            ->get();

        $data = compact('articles', 'videos', 'podcasts', 'streams');

        $resultsCount = count($articles) + count($videos) + count($podcasts) + count($streams);

        return response()->json(compact('resultsCount', 'data'));
    }
}
