<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\Task;
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
}
