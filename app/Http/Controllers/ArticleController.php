<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function all()
    {
        $articles = Article::with('author')->limit(9)->get();
        return response()->json(['data' => $articles]);
    }

    public function paginate()
    {
        $articles = Article::orderBy('date', 'desc')->with('author')->paginate(9);
        return response()->json(['data' => $articles]);
    }

    // @TODO: change to slug
    public function byId($id)
    {
        $article = Article::where('id', $id)->with('author')->get();
        return response()->json(['data' => $article]);
    }
}
