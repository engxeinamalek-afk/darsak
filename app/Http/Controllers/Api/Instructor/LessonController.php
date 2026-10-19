<?php

namespace App\Http\Controllers\Api\instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\StoreLessonController;
use App\Http\Requests\StoreLessonController as RequestsStoreLessonController;
use App\Http\Requests\StoreLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Tag;
use App\Services\ImagesUpload\UploadServiceInterface;
use Illuminate\Support\Facades\Gate;
class LessonController extends Controller
{
    public function store(StoreLessonRequest $request, Course $course){
        $data= $request->validated();

        $lesson= Lesson::create([
            'name' => $data['name'],
            'url' => $data['url'],
            'course_id' => $course->id
        ]);
        return \response()->json([$lesson]);
    }
}
