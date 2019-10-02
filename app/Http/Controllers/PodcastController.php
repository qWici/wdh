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
        $paginationPage = $request->get('page');

        if ($paginationPage <= 3) {
            $cachePageKey = 'podcasts_' . $paginationPage;

            $podcasts = Cache::remember($cachePageKey, 60, function () {
                return Podcast::orderBy('published_at', 'desc')
                    ->with('show')
                    ->paginate(9);
            });

            return response()->json($podcasts);
        }

        $podcasts = Podcast::orderBy('published_at', 'desc')
            ->with('show')
            ->paginate(9);

        return response()->json($podcasts);
    }

    /**
     * Get podcasts by show slug
     *
     * @param string $showSlug
     * @return JsonResponse
     */
    public function byShowSlug(string $showSlug) : JsonResponse
    {
        $show = PodcastShow::where('slug', $showSlug)->firstOrFail();

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
     * @param string $podcastSlug
     * @return JsonResponse
     */
    public function bySlug(string $showSlug, string $podcastSlug) : JsonResponse
    {
        $show = PodcastShow::where('slug', $showSlug)->firstOrFail();

        $podcast = Podcast::where(['slug' => $podcastSlug, 'podcast_show_id' => $show->id])
            ->with('show')
            ->firstOrFail();

        $podcast->bookmarked = $podcast->isFavorited();

        return response()->json($podcast);
    }
}
