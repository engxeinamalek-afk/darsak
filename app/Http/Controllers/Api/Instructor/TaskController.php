<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request, Lesson $lesson){

        $data= $request->validated();
        $task= Task::create([
            'lesson_id' => $lesson->id,
            'name'      => $data['name'],
            'body'      => $data['body'],
        ]);
        return response()->json([$task]);
        
    }

    public function show(Lesson $lesson){
        Gate::authorize('manage', $lesson);
        $task= $lesson->task()
                ->select(['id', 'name', 'body'])
                ->firstOrFail();

        return new TaskResource($task);
    }
}
