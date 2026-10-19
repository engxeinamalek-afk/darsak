<?php

namespace App\Enums;

use App\Models\Post;
use App\Models\Video;

enum TaggableType: string
{
    case COURSE = 'course';
    case LESSON = 'lesson';
    case TASK= 'task';
}

