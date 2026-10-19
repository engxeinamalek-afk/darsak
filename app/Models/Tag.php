<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];
    public function courses()
    {
        return $this->morphedByMany(Course::class, 'taggable');
    }

    public function lessons()
    {
        return $this->morphedByMany(Lesson::class, 'taggable');
    }

    public function tasks(){
        return $this->morphedByMany(Task::class, 'taggable');
    }
}
