<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Instructor\CommentController as InstructorCommentController;
use App\Http\Controllers\Api\instructor\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Instructor\ImageController;
use App\Http\Controllers\Api\instructor\LessonController;
use App\Http\Controllers\Api\Instructor\TagController;
use App\Http\Controllers\Api\Instructor\TaskController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Student\CommentController;
use App\Http\Controllers\Api\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Api\Student\LessonController as StudentLessonController;
use App\Http\Controllers\Api\Student\TagController as StudentTagController;
use App\Http\Controllers\Api\Student\TaskController as StudentTaskController;
use Illuminate\Support\Facades\Auth;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum','role:instructor'])->prefix('instructor')->group(function(){

    Route::post('/tags/{taggable_type}/{taggable}', [TagController::class, 'attach']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::get('/tags/{tag}/resources',[TagController::class, 'show']);

    Route::post('/images/{imageable_type}/{imageable}', [ImageController::class, 'store']);            
    Route::post('/images', [ProfileController::class, 'storeImage'])->name('instructor.image');   

    Route::post('/courses', [CourseController::class, 'store']);
    Route::patch('/courses/{instructor_course}',[CourseController::class, 'update']);
    Route::get('/courses',[CourseController::class, 'index']);


    Route::post('/lessons/{instructor_course}', [LessonController::class, 'store']);
    Route::get('/courses/{instructor_course}/lessons', [LessonController::class, 'index']);

    Route::post('/lessons/{lesson}/tasks', [TaskController::class, 'store']);
    Route::get('/lessons/{lesson}/tasks', [TaskController::class, 'show']);

    Route::get('/commentables' , [InstructorCommentController::class, 'index']);

});


Route::middleware(['auth:sanctum','role:student'])->prefix('student')->group(function(){
    Route::post('/comments/{commentable_type}/{commentable}', [CommentController::class, 'store']);

    Route::get('/lessons/{lesson}/tasks', [StudentTaskController::class, 'show']);
    Route::get('/courses/{course}/lessons', [StudentLessonController::class, 'index']);
    Route::get('/courses',[StudentCourseController::class, 'index']);

    Route::get('/tags/{tag}/resources',[StudentTagController::class, 'show']);



});