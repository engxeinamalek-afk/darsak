<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Scopes\PublishedCoursesScope;

class LessonPolicy
{
    public function manage(User $user, Lesson $lesson): bool
    {
        $course= $lesson->course()
                ->withoutGlobalScope(PublishedCoursesScope::class)->first();
        return $course
            && $user->id === $course->instructor_id;
    }

    public function access(User $user, Lesson $lesson): bool
    {
        return $user->enrolledCourses()->wherePivot('course_id',$lesson->course_id)->exists();
    }
}
