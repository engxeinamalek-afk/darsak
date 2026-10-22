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
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Gate;
class LessonController extends Controller
{
    use ApiResponse;
    public function store(StoreLessonRequest $request, Course $course){
        $data= $request->validated();

        $lesson= Lesson::create([
            'name' => $data['name'],
            'url' => $data['url'],
            'course_id' => $course->id
        ]);

        return $this->successResponse(new LessonResource($lesson), "lesson created successfully");
    }

    public function index(Course $course){
        Gate::authorize('manage', $course);
        $lessons= $course->lessons()
                    ->withDetails()
                    ->paginate(10);

        return $this->successResponse(data:['lessons'    => LessonResource::collection($lessons),
                                            'pagination' => [
                                                'current_page' => $lessons->currentPage(),
                                                'next_page'    => $lessons->nextPageUrl(),
                                                'prev_page'    => $lessons->previousPageUrl(),
                                                'total_pages'  => $lessons->lastPage(),
                                            ]],
                                      message:"Lessons retrieved successfully");
    }
}
