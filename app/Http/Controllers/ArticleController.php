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
}
