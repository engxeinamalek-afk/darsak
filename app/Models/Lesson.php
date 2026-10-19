<?php

namespace App\Models;

use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasImage;
use App\Models\Concerns\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasComments,HasTags,HasImage;
    protected $fillable = ['name', 'course_id', 'url'];
    public function course(): BelongsTo{
        return $this->belongsTo(Course::class);
    }
}
