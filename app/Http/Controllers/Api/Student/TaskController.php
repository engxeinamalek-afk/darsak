<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\TaskResource;
use App\Traits\ApiResponse;

class TaskController extends Controller
{
    use ApiResponse;
    public function show(Lesson $lesson){
        Gate::authorize('access', $lesson);
        $task= $lesson->task()
                ->select(['id', 'name', 'body'])
                ->firstOrFail();

        return $this->successResponse(new TaskResource($task),"Task retrieved successfully");
    }
}
