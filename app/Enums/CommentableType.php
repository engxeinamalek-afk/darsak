<?php

namespace App\Enums;

enum CommentableType: string
{
    case COURSE = 'course';
    case LESSON = 'lesson';
    case TASK= 'task';
}
