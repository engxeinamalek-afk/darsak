<?php

namespace App\Models;

use App\Enums\CourseStatus;
use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasImage;
use App\Models\Concerns\HasTags;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasComments,HasTags,HasImage;
    protected $fillable = ['name', 'instructor_id', 'status'];

    protected function casts(): array{
        return [
            'status' => CourseStatus::class
        ];
    }
}
