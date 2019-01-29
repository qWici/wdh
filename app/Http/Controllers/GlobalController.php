<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GlobalController extends Controller
{
    public function getLast(Request $request) : JsonResponse
    {
        $page = $request->get('page');

        if ($page <= 3) {
            $cachePageKey = 'last_' . $request->get('page');

            $last = Cache::remember($cachePageKey, 60, function () {
                $items = Content::orderBy('updated_at', 'desc')->paginate(9);
                return $this->getItemsAuthor($items);
            });

            return response()->json($last);
        }

        $items = Content::orderBy('updated_at', 'desc')->paginate(9);

        return response()->json($this->getItemsAuthor($items));
    }

    private function getItemsAuthor($items)
    {
        $content = collect();

        foreach ($items as $item) {
            $content->push($this->getItemWithAuthor($item->contentable));
        }

        return $content;
    }

    private function getItemWithAuthor($item)
    {
        if (collect($item)->has('author_id')) {
            return $item->load('author');
        }

        if (collect($item)->has('podcast_show_id')) {
            return $item->load('show');
        }

        if (collect($item)->has('channel_id')) {
            return $item->load('channel');
        }
    }
}
