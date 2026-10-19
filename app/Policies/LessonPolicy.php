<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Lesson;
class LessonPolicy
{
    public function manage(User $user, Lesson $lesson): bool
    {
        return $lesson->course && $user->id === $lesson->course->instructor_id;
    }

    public function access(User $user, Lesson $lesson): bool
    {
        return $user->enrolledCourses()->wherePivot('course_id',$lesson->course_id)->exists();
    }
}
