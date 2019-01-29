<?php
namespace App\Traits;
use App\Models\Content;

trait Contentable
{
    public function contents()
    {
        return $this->morphMany(Content::class, 'contentable');
    }

    public function addContent($updated_at = null)
    {
        $content = new Content(['updated_at' => $updated_at ?: $this->updated_at]);
        $this->contents()->save($content);
    }
}
