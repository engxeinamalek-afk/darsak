<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\instructor\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Instructor\ImageController;
use App\Http\Controllers\Api\instructor\LessonController;
use App\Http\Controllers\Api\Instructor\TagController;
use App\Http\Controllers\Api\Instructor\TaskController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Student\CommentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum','role:instructor'])->prefix('instructor')->group(function(){

    Route::post('/tags/{taggable_type}/{taggable}', [TagController::class, 'attach']);
    Route::post('/tags', [TagController::class, 'store']);

    Route::post('/images/{imageable_type}/{imageable}', [ImageController::class, 'store']);            
    Route::post('/images', [ProfileController::class, 'storeImage'])->name('instructor.image');   

    Route::post('/courses', [CourseController::class, 'store']);
    Route::patch('/courses/{instructor_course}',[CourseController::class, 'update']);
    Route::get('/courses',[CourseController::class, 'index']);


    Route::post('/lessons/{instructor_course}', [LessonController::class, 'store']);
    Route::get('/lessons/{instructor_course}', [LessonController::class, 'index']);

    Route::post('/tasks/{lesson}', [TaskController::class, 'store']);
    Route::get('/tasks/{lesson}', [TaskController::class, 'show']);

});


Route::middleware(['auth:sanctum','role:student'])->prefix('student')->group(function(){
    Route::post('/comments/{commentable_type}/{commentable}', [CommentController::class, 'store']);

});