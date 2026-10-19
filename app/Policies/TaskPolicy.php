<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;
class TaskPolicy
{
    public function manage(User $user, Task $task): bool
    {
        return $task->course
            && $user->id === $task->course->instructor_id;
    }

    public function access(User $user, Task $task): bool
    {
        $courseId= $task->course()->value('courses.id');
        return $user->enrolledCourses()->wherePivot('course_id',$courseId)->exists();
    }
}
