<?php

namespace App\Enums;

enum ImageableType:string
{
    case COURSE = 'course';
    case LESSON = 'lesson';
    case INSTRUCTOR= 'instructor';
}
