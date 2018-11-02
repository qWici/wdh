<?php

namespace App\Console\Commands\Parsers;

use App\Helpers\RemoteRequest;
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
    protected $signature = 'parse:authors';

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
        $response = RemoteRequest::getRemoteContent('https://gitlab.com/api/v4/projects/8927048/repository/files/authors.min.json/raw?ref=master');
        $authors = json_decode($response['data']);
        foreach ($authors as $author) {
            $authorSlug = str_slug($author->name);
            $author->slug = $authorSlug;

            if(Author::where('slug', $author->slug)->exists()) {
                continue;
            }

            $newAuthor = Author::create((array) $author);
            $this->storeAndUpdateLogo($newAuthor);
        }
    }

    public function storeAndUpdateLogo($author)
    {
        $imageURL = $author->logo;
        $imagePath = "/images/authors/" . $author->slug . ".webp";
        Image::make($imageURL)->encode('webp', 75)->save("public" . $imagePath);
        $author->logo = $imagePath;
        $author->save();
    }
}
