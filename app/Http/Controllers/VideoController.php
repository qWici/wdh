<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function paginate()
    {
        $videos = Video::orderBy('published_at', 'desc')->with('channel')->paginate(9);
        return response()->json(['data' => $videos]);
    }

    public function bySlug($channel, $slug)
    {
        $video = Video::where('slug', $slug)->orderBy('published_at', 'desc')->with('channel')->get();
        return response()->json(['data' => $video]);
    }
}
