<?php

use App\Models\{Article,Video,Podcast};
use Illuminate\Database\Seeder;

class MakeAllContentContentable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = [Article::class, Video::class, Podcast::class];

        foreach ($models as $model) {
            foreach ($model::cursor() as $item) {
                if (collect($item)->has('author_id')) {
                    $item->addContent($item->date);
                    continue;
                }

                $item->addContent($item->published_at);
            }
        }
    }
}
