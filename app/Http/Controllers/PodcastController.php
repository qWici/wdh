<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use App\Models\PodcastShow;
use Illuminate\Http\JsonResponse;

class PodcastController extends Controller
{
    /**
     * Get paginated podcasts
     *
     * @return JsonResponse
     */
    public function paginate() : JsonResponse
    {
        $podcasts = Podcast::orderBy('published_at', 'desc')
            ->with('show')
            ->paginate(9);

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
        $show = PodcastShow::where('slug', $slug)
            ->get()
            ->first();

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
        $show = PodcastShow::where('slug', $showSlug)
            ->get()
            ->first();

        $podcast = Podcast::where(['slug' => $slug, 'podcast_show_id' => $show->id])
            ->with('show')
            ->get()
            ->first();

        return response()->json($podcast);
    }
}
