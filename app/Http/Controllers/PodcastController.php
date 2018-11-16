<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use App\Models\PodcastShow;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    public function paginate()
    {
        $podcasts = Podcast::orderBy('published_at', 'desc')->with('show')->paginate(9);
        return response()->json(['data' => $podcasts]);
    }

    public function byShowSlug($slug)
    {
        $show = PodcastShow::where('slug', $slug)->get()->first();
        $podcasts = Podcast::where('podcast_show_id', $show->id)->orderBy('published_at', 'desc')->with('show')->paginate(9);
        return response()->json($podcasts);
    }

    public function bySlug($showSlug, $slug)
    {
        $show = PodcastShow::where('slug', $showSlug)->get()->first();
        $podcast = Podcast::where(['slug' => $slug, 'podcast_show_id' => $show->id])->with('show')->get();
        return response()->json(['data' => $podcast]);
    }
}
