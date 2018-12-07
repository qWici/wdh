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

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        $user = $request->user();

        $bookmarks = [
            $user->favorite(Article::class),
            $user->favorite(Podcast::class),
            $user->favorite(Video::class),
            $user->favorite(Stream::class)
        ];

        $user->bookmarks = $this->prepareBookmarks($bookmarks);

        return response()->json($user);
    }

    public function prepareBookmarks(array $bookmarks)
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

    public function getItemAuthor($item)
    {
        switch ($item->type) {
            case 'article':
                return $item->author = Author::where('id', $item->author_id)->first();
            case 'podcast':
                return $item->show = PodcastShow::where('id', $item->podcast_show_id)->first();
            case 'video':
                return $item->channel = Channel::where('id', $item->channel_id)->first();
        }
    }
}
