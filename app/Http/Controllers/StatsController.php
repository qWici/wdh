<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Podcast;
use App\Models\Stream;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function base(Request $request)
    {
        $stats = [
            "videos" => Video::get()->count(),
            "articles" => Article::get()->count(),
            "streams" => Stream::get()->count(),
            "podcasts" => Podcast::get()->count()
        ];

        return response()->json($stats);
    }
}
