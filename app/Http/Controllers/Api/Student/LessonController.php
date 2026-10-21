<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Gate;
class LessonController extends Controller
{
    public function index(Course $course){
        Gate::authorize('access', $course);
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
