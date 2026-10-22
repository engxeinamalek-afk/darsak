<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    use ApiResponse;
    public function store(StoreTaskRequest $request, Lesson $lesson){

        $data= $request->validated();
        $task = Task::updateOrCreate(
            ['lesson_id' => $lesson->id],
            [
                'name' => $data['name'],
                'body' => $data['body'],
            ]
        );
        return $this->successResponse(new TaskResource($task), "Task created successfully",201);
        
    }

    public function show(Lesson $lesson){
        Gate::authorize('manage', $lesson);
        $task= $lesson->task()
                ->select(['id', 'name', 'body'])
                ->firstOrFail();

        return $this->successResponse(new TaskResource($task), "Task retrieved successfully");
    }
}
