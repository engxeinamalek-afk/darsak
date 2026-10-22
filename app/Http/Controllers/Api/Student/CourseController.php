<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Traits\ApiResponse;

class CourseController extends Controller
{
    use ApiResponse;
    public function index(){
        $user= auth()->user();
        $courses= $user->enrolledCourses()
                    ->withDetails()
                    ->paginate(10);

        return $this->successResponse(data:[
                                        'courses'    => CourseResource::collection($courses),
                                        'pagination' => [
                                            'current_page' => $courses->currentPage(),
                                            'next_page'    => $courses->nextPageUrl(),
                                            'prev_page'    => $courses->previousPageUrl(),
                                            'total_pages'  => $courses->lastPage(),
                                        ]
                                    ], message:"Courses retrieved successfully");
    }
}
