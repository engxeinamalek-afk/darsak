<?php

namespace App\Models\Concerns;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
trait HasImage
{
    public function image()
    {
        /** @var Model $this */
        return $this->morphOne(Image::class, 'imageable');
    }
}
