<?php

namespace App\Models\Concerns;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
trait HasComments
{
    public function comments()
    {
        /** @var Model $this */
        return $this->morphMany(Comment::class, 'commentable');
    }
}
