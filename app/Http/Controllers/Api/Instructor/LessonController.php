<?php

namespace App\Http\Controllers\Api\instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\StoreLessonController;
use App\Http\Requests\StoreLessonController as RequestsStoreLessonController;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Resources\LessonResource;
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

    public function index(Course $course){
        Gate::authorize('manage', $course);
        $lessons= $course->lessons()
                    ->withDetails()
                    ->paginate(10);

        return response()->json([
            'courses'    => LessonResource::collection($lessons),
            'pagination' => [
                'current_page' => $lessons->currentPage(),
                'next_page'    => $lessons->nextPageUrl(),
                'prev_page'    => $lessons->previousPageUrl(),
                'total_pages'  => $lessons->lastPage(),
            ]
        ]);
    }
}
