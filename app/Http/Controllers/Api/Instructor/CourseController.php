<?php

namespace App\Http\Controllers\Api\instructor;

use App\Enums\CourseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Services\ImagesUpload\UploadServiceInterface;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;
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
}
