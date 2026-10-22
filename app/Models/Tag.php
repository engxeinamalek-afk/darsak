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
    
    public function loadRelationsForStudent(int $studentId): self
    {
        return $this->load([
            'courses' => function ($query) use ($studentId) {
                $query->select('courses.id', 'courses.name', 'courses.instructor_id')
                    ->whereHas('students', function ($q) use ($studentId) {
                        $q->where('users.id', $studentId);
                    });
            },
            'lessons' => function ($query) use ($studentId) {
                $query->select('lessons.id', 'lessons.name', 'lessons.url', 'lessons.course_id') 
                    ->whereHas('course.students', function ($q) use ($studentId) {
                        $q->where('users.id', $studentId);
                    });
            },   
            'tasks' => function ($query) use ($studentId) {
                $query->select('tasks.id', 'tasks.name', 'tasks.body', 'tasks.lesson_id') 
                    ->whereHas('lesson.course.students', function ($q) use ($studentId) {
                        $q->where('users.id', $studentId);
                    }); 
            }
        ]);
    }

}
