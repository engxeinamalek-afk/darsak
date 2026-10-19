<?php

namespace App\Models\Concerns;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
trait HasTags
{
    public function tags()
    {
        /** @var Model $this */
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
