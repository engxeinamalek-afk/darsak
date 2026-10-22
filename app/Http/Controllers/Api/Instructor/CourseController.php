<?php

namespace App\Http\Controllers\Api\instructor;

use App\Enums\CourseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Scopes\PublishedCoursesScope;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    use ApiResponse;
    public function store(StoreCourseRequest $request){
        $data= $request->validated();

        $course= Course::create([
            'name' => $data['name'],
            'instructor_id' => auth()->user()->id,
            'status' => CourseStatus::DRAFT
        ]);

        return $this->successResponse(new CourseResource($course), 'Course Created successfully', 201);
    }

    public function update(UpdateCourseRequest $request, Course $course){
        $data= $request->validated();

        $course->update(['status' => $data['status']]);


        if ($course->wasChanged('status')) {
            return $this->successResponse(message:"Course status updated successfully.",
                                            statusCode:200);
        }

        return $this->successResponse(message: "No new changes provided; status is identical to the current one.", 
                                        statusCode:200);

    }

    public function index(){
        $user= auth()->user();
        $courses= $user->courses()
                    ->withoutGlobalScope(PublishedCoursesScope::class)
                    ->withDetails()
                    ->paginate(10);

        return $this->successResponse(data:['courses'=> CourseResource::collection($courses),
                                            'pagination' => [
                                                'current_page' => $courses->currentPage(),
                                                'next_page'    => $courses->nextPageUrl(),
                                                'prev_page'    => $courses->previousPageUrl(),
                                                'total_pages'  => $courses->lastPage(),
                                            ]],
                                      message: 'Courses retrieved successfully', statusCode:200 );
    }

}
