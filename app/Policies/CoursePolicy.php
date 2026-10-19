<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
class CoursePolicy
{
    public function manage(User $user, Course $course): bool
    {
        return $user->id === $course->instructor_id;
    }
}
