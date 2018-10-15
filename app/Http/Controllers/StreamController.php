<?php

namespace App\Http\Controllers;

use App\Models\Stream;

class StreamController extends Controller
{
    public function all()
    {
        return response()->json(['data' => Stream::all()]);
    }

    public function online()
    {
        $streams = Stream::where('online', true)->get();
        return response()->json(['count' => $streams->count(), 'data' => $streams]);
    }
}
