<?php

namespace App\Models;

use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasImage;
use App\Models\Concerns\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class Lesson extends Model
{
    use HasComments,HasTags,HasImage;
    protected $fillable = ['name', 'course_id', 'url'];
    public function course(): BelongsTo{
        return $this->belongsTo(Course::class);
    }

    public function task():HasOne{
        return $this->hasOne(Task::class);
    }

    public function scopeWithDetails(Builder $query): Builder
    {
        return $query->select(['id', 'course_id', 'name', 'url'])
                     ->with(['task:id,lesson_id,name,body']);
    }
}
