<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VideoController extends Controller
{
    /**
     * Get paginated videos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function paginate(Request $request) : JsonResponse
    {
        $cachePageKey = 'videos' . $request->get('page');

        $videos = Cache::remember($cachePageKey, 60, function () {
            return Video::orderBy('published_at', 'desc')
                ->with('channel')
                ->paginate(9);
        });

        return response()->json($videos);
    }

    /**
     * Get videos by channel slug
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function byChannelSlug(string $slug) : JsonResponse
    {
        $channel = Channel::where('slug', $slug)->first();

        $videos = Video::where('channel_id', $channel->id)
            ->orderBy('published_at', 'desc')
            ->with('channel')
            ->paginate(9);

        return response()->json($videos);
    }

    /**
     * Get videos by channel & own slug
     *
     * @param string $channelSlug
     * @param string $slug
     * @return JsonResponse
     */
    public function bySlug(string $channelSlug, string $slug) : JsonResponse
    {
        $channel = Channel::where('slug', $channelSlug)->first();

        $video = Video::where(['slug' => $slug, 'channel_id' => $channel->id])
            ->with('channel')
            ->first();

        $video->bookmarked = $video->isFavorited();

        return response()->json($video);
    }
}
