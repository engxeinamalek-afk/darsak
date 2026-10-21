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
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function store(StoreCourseRequest $request){
        $data= $request->validated();

        $course= Course::create([
            'name' => $data['name'],
            'instructor_id' => auth()->user()->id,
            'status' => CourseStatus::DRAFT
        ]);

        return response()->json([$course]);
    }

    public function update(UpdateCourseRequest $request, Course $course){
        $data= $request->validated();

        $course->update(['status' => $data['status']]);


        if ($course->wasChanged('status')) {
            return response()->json(['message' => 'تم تحديث حالة الكورس بنجاح.']);
        }

        return response()->json(['message' => 'لم يتم إدخال قيمة جديدة، الحالة مطابقة للحالية.']);

    }

    public function index(){
        $user= auth()->user();
        $courses= $user->courses()
                    ->withoutGlobalScope(PublishedCoursesScope::class)
                    ->withDetails()
                    ->paginate(10);
        return response()->json([
            'courses'    => CourseResource::collection($courses),
            'pagination' => [
                'current_page' => $courses->currentPage(),
                'next_page'    => $courses->nextPageUrl(),
                'prev_page'    => $courses->previousPageUrl(),
                'total_pages'  => $courses->lastPage(),
            ]
        ]);
    }

}
