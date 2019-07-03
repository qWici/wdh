<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Author;
use App\Models\Channel;
use App\Models\Podcast;
use App\Models\PodcastShow;
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

        $item = $model::where('id', $itemID)->get()->firstOrFail();
        $item->toggleFavorite();

        return response()->json(["status" => $item->isFavorited()],200);
    }

    public function byType(Request $request)
    {
        $type = $request->get('type');

        $user = Auth::user();

        $favorites = $user->favorite($this->getModel($type));

        return response()->json($favorites);
    }

    public function forUser(Request $request)
    {
        $user = $request->user();
        $page = $request->get('page');

        $allBookmarks = [
            $user->favorite(Article::class),
            $user->favorite(Podcast::class),
            $user->favorite(Video::class),
            $user->favorite(Stream::class)
        ];

        $bookmarks = collect($this->prepareBookmarks($allBookmarks))->chunk(9);

        if ($page >= count($bookmarks)) {
            return response()->json([]);
        }

        return response()->json(array_values($bookmarks[$page]->toArray()));
    }

    private function getModel(string $type)
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

    private function prepareBookmarks(array $bookmarks)
    {
        $data = [];

        foreach ($bookmarks as $bookmark) {
            foreach ($bookmark as $item) {
                $item->type = strtolower(class_basename($item));

                if ($item->type === 'stream') {
                    if (!$item->online) {
                        continue;
                    }
                }

                $item->author = $this->getItemAuthor($item);

                $data[] = $item->toArray();
            }
        }
        return $data;
    }

    private function getItemAuthor($item)
    {
        switch ($item->type) {
            case 'article':
                return $item->author = Author::where('id', $item->author_id)->firstOrFail();
            case 'podcast':
                return $item->show = PodcastShow::where('id', $item->podcast_show_id)->firstOrFail();
            case 'video':
                return $item->channel = Channel::where('id', $item->channel_id)->firstOrFail();
        }
    }
}
