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
        $paginationPage = $request->get('page');

        if ($paginationPage <= 3) {
            $cachePageKey = 'articles_' . $paginationPage;

            $articles = Cache::remember($cachePageKey, 60, function () {
                return Article::orderBy('date', 'desc')
                    ->with('author')
                    ->paginate(9);
            });

            return response()->json($articles);
        }

        $articles = Article::orderBy('date', 'desc')
            ->with('author')
            ->paginate(9);

        return response()->json($articles);
    }

    /**
     * Get articles by author slug
     *
     * @param string $authorSlug
     * @return JsonResponse
     */
    public function byAuthorSlug(string $authorSlug) : JsonResponse
    {
        $author = Author::where('slug', $authorSlug)->firstOrFail();

        $articles = Article::where('author_id', $author->id)
            ->orderBy('date', 'desc')
            ->with('author')
            ->paginate(9);

        return response()->json($articles);
    }

    /**
     * Get article by author & own slug
     *
     * @param string $authorSlug
     * @param string $articleSlug
     * @return JsonResponse
     */
    public function bySlug(string $authorSlug, string $articleSlug) : JsonResponse
    {
        $author = Author::where('slug', $authorSlug)->firstOrFail();

        $article = Article::where(['slug' => $articleSlug, 'author_id' => $author->id])
            ->with('author')
            ->firstOrFail();

        $article->bookmarked = $article->isFavorited();

        return response()->json($article);
    }
}
