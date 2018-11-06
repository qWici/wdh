<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function paginate()
    {
        $videos = Video::orderBy('published_at', 'desc')->with('channel')->paginate(9);
        return response()->json(['data' => $videos]);
    }

    public function bySlug($channelSlug, $slug)
    {
        $channel = Channel::where('slug', $channelSlug)->get()->first();
        $video = Video::where(['slug' => $slug, 'channel_id' => $channel->id])->with('channel')->get();
        return response()->json(['data' => $video]);
    }
}
