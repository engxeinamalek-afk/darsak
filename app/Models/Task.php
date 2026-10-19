<?php

namespace App\Models;

use App\Models\Concerns\HasComments;
use App\Models\Concerns\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
class Task extends Model
{
    use HasComments,HasTags;
    protected $fillable = ['name', 'body', 'lesson_id'];

    public function course(): HasOneThrough
    {
        return $this->hasOneThrough(
            Course::class, 
            Lesson::class,
            'id',          
            'id',          
            'lesson_id',   
            'course_id'   
        );
    }
}
