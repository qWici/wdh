<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    /**
     * Get all articles
     *
     * @return JsonResponse
     */
    public function all() : JsonResponse
    {
        $articles = Article::with('author')
            ->limit(9)
            ->get();

        return response()->json($articles);
    }

    /**
     * Get paginated articles
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function paginate(Request $request) : JsonResponse
    {
        $cachePageKey = 'articles' . $request->get('page');

        $articles = Cache::remember($cachePageKey, 60, function () {
            return Article::orderBy('date', 'desc')
                ->with('author')
                ->paginate(9);
        });

        return response()->json($articles);
    }

    /**
     * Get articles by author slug
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function byAuthorSlug(string $slug) : JsonResponse
    {
        $author = Author::where('slug', $slug)
            ->get()
            ->first();

        $articles = Article::where('author_id', $author->id)
            ->orderBy('date', 'desc')
            ->with('author')
            ->paginate(9);

        return response()->json($articles);
    }

    /**
     * Get article by author & own slug
     *
     * @param string $author
     * @param string $slug
     * @return JsonResponse
     */
    public function bySlug(string $author, string $slug) : JsonResponse
    {
        $author = Author::where('slug', $author)
            ->get()
            ->first();

        $article = Article::where(['slug' => $slug, 'author_id' => $author->id])
            ->with('author')
            ->get()
            ->first();

        return response()->json($article);
    }
}
