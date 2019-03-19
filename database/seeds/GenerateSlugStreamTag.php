<?php

use App\Models\StreamTag;
use Illuminate\Database\Seeder;

class GenerateSlugStreamTag extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (StreamTag::cursor() as $tag) {
            $tag->slug = str_slug($tag->tag);
            $tag->save();
        }
    }
}
