<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use App\Models\PodcastShow;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PodcastController extends Controller
{
    /**
     * Get paginated podcasts
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function paginate(Request $request) : JsonResponse
    {
        $cachePageKey = 'podcasts' . $request->get('page');

        $podcasts = Cache::remember($cachePageKey, 60, function () {
            return Podcast::orderBy('published_at', 'desc')
                ->with('show')
                ->paginate(9);
        });

        return response()->json($podcasts);
    }

    /**
     * Get podcasts by show slug
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function byShowSlug(string $slug) : JsonResponse
    {
        $show = PodcastShow::where('slug', $slug)->first();

        $podcasts = Podcast::where('podcast_show_id', $show->id)
            ->orderBy('published_at', 'desc')
            ->with('show')
            ->paginate(9);

        return response()->json($podcasts);
    }

    /**
     * Get podcasts by show & own slug
     *
     * @param string $showSlug
     * @param string $slug
     * @return JsonResponse
     */
    public function bySlug(string $showSlug, string $slug) : JsonResponse
    {
        $show = PodcastShow::where('slug', $showSlug)->first();

        $podcast = Podcast::where(['slug' => $slug, 'podcast_show_id' => $show->id])
            ->with('show')
            ->first();

        $podcast->bookmarked = $podcast->isFavorited();

        return response()->json($podcast);
    }
}
