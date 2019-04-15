<?php

namespace App\Console\Commands\Parsers;

use App\Helpers\ParseResource;
use App\Models\Author;
use Illuminate\Console\Command;
use Image;

class ParseAuthors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:authors {update?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse article authors';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $authors = ParseResource::getData('authors');

        foreach ($authors as $author) {
            $author->slug = str_slug($author->name);
            $author = json_decode(json_encode($author), true); // Convert stdClass to array

            $author = Author::updateOrCreate(["slug" => $author['slug']], $author);
            $this->storeAndUpdateLogo($author);
        }
    }

    /**
     * Store logo to public folder in .webp format
     *
     * @param $author
     */
    public function storeAndUpdateLogo($author)
    {
        $imageURL = $author->logo;
        $imagePath = "/images/authors/" . $author->slug . ".png";
        Image::make($imageURL)->encode('png', 75)->save("public" . $imagePath);
        $author->logo = $imagePath;
        $author->save();
    }
}
