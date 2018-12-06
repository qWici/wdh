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
        $streams = Stream::where('online', true)->paginate(9);

        foreach ($streams as $stream) {
            $stream->bookmarked = $stream->isFavorited();
        }

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
            ->first();

        return response()->json($tag->stream);
    }

    /**
     * Fetch stream info by twitch name slug
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function bySlug(string $slug) : JsonResponse
    {
        $stream = Stream::where('twitch', $slug)->first();

        $stream->bookmarked = $stream->isFavorited();

        return response()->json($stream);
    }
}
