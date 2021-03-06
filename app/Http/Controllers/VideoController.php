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
        $paginationPage = $request->get('page');

        if ($paginationPage <= 3) {
            $cachePageKey = 'videos_' . $paginationPage;

            $videos = Cache::remember($cachePageKey, 60, function () {
                return Video::orderBy('published_at', 'desc')
                    ->with('channel')
                    ->paginate(9);
            });

            return response()->json($videos);
        }


        $videos = Video::orderBy('published_at', 'desc')
            ->with('channel')
            ->paginate(9);

        return response()->json($videos);
    }

    /**
     * Get videos by channel slug
     *
     * @param string $channelSlug
     * @return JsonResponse
     */
    public function byChannelSlug(string $channelSlug) : JsonResponse
    {
        $channel = Channel::where('slug', $channelSlug)->firstOrFail();

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
     * @param string $videoSlug
     * @return JsonResponse
     */
    public function bySlug(string $channelSlug, string $videoSlug) : JsonResponse
    {
        $channel = Channel::where('slug', $channelSlug)->firstOrFail();

        $video = Video::where(['slug' => $videoSlug, 'channel_id' => $channel->id])
            ->with('channel')
            ->firstOrFail();

        $video->bookmarked = $video->isFavorited();

        return response()->json($video);
    }
}
