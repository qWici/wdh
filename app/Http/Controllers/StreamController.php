<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use App\Models\StreamTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StreamController extends Controller
{
    /**
     * Get all streams
     *
     * @return JsonResponse
     */
    public function all() : JsonResponse
    {
        return response()->json([ Stream::all() ]);
    }

    /**
     * Get live streams
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function online(Request $request) : JsonResponse
    {
        $cachePageKey = 'streams' . $request->get('page');

        $streams = Cache::remember($cachePageKey, 15, function () {
            return Stream::where('online', true)->paginate(9);
        });

        return response()->json($streams);
    }

    /**
     * Get last live streams
     *
     * @return JsonResponse
     */
    public function lastonline() : JsonResponse
    {
        $streams = Stream::orderBy('updated_at', 'desc')
            ->whereNotNull('title')
            ->where('online', false)
            ->take(9)
            ->get();

        return response()->json($streams);
    }

    /**
     * Get stream tags by twitch name
     *
     * @param string $twitchname
     * @return JsonResponse
     */
    public function tags(string $twitchname) : JsonResponse
    {
        $stream = Stream::where('twitch', $twitchname)
            ->with('tags')
            ->get()
            ->first();

        return response()->json($stream->tags);
    }

    /**
     * Get streams by tag
     *
     * @param string $tag
     * @return JsonResponse
     */
    public function byTag(string $tag) : JsonResponse
    {
        $tag = StreamTag::where('tag', $tag)
            ->with('stream')
            ->get()
            ->first();

        return response()->json($tag->stream);
    }
}
