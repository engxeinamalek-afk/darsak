<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
class CourseController extends Controller
{
    public function index(){
        $user= auth()->user();
        $courses= $user->enrolledCourses()
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
