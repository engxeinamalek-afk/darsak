<?php

namespace App\Models;

use App\Enums\CourseStatus;
use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasImage;
use App\Models\Concerns\HasTags;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\PublishedCoursesScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;
    use HasComments,HasTags,HasImage;
    protected $fillable = ['name', 'instructor_id', 'status'];

    protected static function booted(): void
    {
        static::addGlobalScope(new PublishedCoursesScope);
    }
    protected function casts(): array{
        return [
            'status' => CourseStatus::class
        ];
    }
    public function lessons():HasMany{
        return $this->hasMany(Lesson::class);
    }
    public function scopeWithDetails(Builder $query)
    {
        return $query->select(['courses.id', 'name', 'status', 'instructor_id'])
            ->with([
                'lessons' => function ($q) {
                    $q->select(['id', 'course_id', 'name', 'url'])
                    ->with(['task:id,lesson_id,name,body']);
                }
            ]);
    }

    public function students(): BelongsToMany{
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'student_id');
    }
}
