<?php

namespace App\Policies;

use App\Models\Scopes\PublishedCoursesScope;
use App\Models\User;
use App\Models\Task;
class TaskPolicy
{
    public function manage(User $user, Task $task): bool
    {
        $course= $task->course()
                ->withoutGlobalScope(PublishedCoursesScope::class)->first();
        return $course
            && $user->id === $course->instructor_id;
    }

    public function access(User $user, Task $task): bool
    {
        $courseId= $task->course()->value('courses.id');
        return $user->enrolledCourses()->wherePivot('course_id',$courseId)->exists();
    }
}
