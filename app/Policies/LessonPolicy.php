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
}
