<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Podcast;
use App\Models\Stream;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function toggle(Request $request)
    {
        $itemID = $request->get('id');
        $type = $request->get('type');

        $model = $this->getModel($type);

        $model::where('id', $itemID)->get()->first()->toggleFavorite();

        return response()->json([],200);
    }

    public function get(Request $request)
    {
        $type = $request->get('type');

        $user = Auth::user();

        $favorites = $user->favorite($this->getModel($type));

        return response()->json($favorites);
    }

    public function getModel(string $type)
    {
        switch ($type) {
            case 'article':
                return Article::class;
                break;
            case 'video':
                return Video::class;
                break;
            case 'stream':
                return Stream::class;
                break;
            case 'podcast':
                return Podcast::class;
                break;
        }
    }
}
