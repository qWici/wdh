<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function all()
    {
        $articles = Article::with('author')->limit(9)->get();
        return response()->json($articles);
    }

    public function paginate()
    {
        $articles = Article::orderBy('date', 'desc')->with('author')->paginate(9);
        return response()->json($articles);
    }

    public function byAuthorSlug($slug)
    {
        $author = Author::where('slug', $slug)->get()->first();
        $articles = Article::where('author_id', $author->id)->orderBy('date', 'desc')->with('author')->paginate(9);
        return response()->json($articles);
    }

    public function bySlug($author, $slug)
    {
        $author = Author::where('slug', $author)->get()->first();
        $article = Article::where(['slug' => $slug, 'author_id' => $author->id])->with('author')->get()->first();
        return response()->json($article);
    }
}
