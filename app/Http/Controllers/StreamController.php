<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use App\Models\StreamTag;

class StreamController extends Controller
{
    public function all()
    {
        return response()->json(['data' => Stream::all()]);
    }

    public function online()
    {
        $streams = Stream::where('online', true)->get();
        return response()->json(['count' => $streams->count(), 'data' => $streams]);
    }

    public function lastonline()
    {
        $streams = Stream::orderBy('updated_at', 'desc')->whereNotNull('title')->where('online', false)->take(10)->get();
        return response()->json(['count' => $streams->count(), 'data' => $streams]);
    }

    public function tags($twitchname)
    {
        $stream = Stream::where('twitch', $twitchname)->with('tags')->get()->first();
        return response()->json(['data' => $stream->tags]);
    }
}
