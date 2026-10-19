<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Instructor\ImageController;
use App\Http\Controllers\Api\Instructor\TagController;
use App\Http\Controllers\Api\ProfileController;

Route::middleware(['auth:sanctum','role:instructor'])->prefix('admin')->group(function(){
    Route::post('/tags/{taggable_type}/{taggable}', [TagController::class, 'attach']);

    Route::post('/images/{imageable_type}/{imageable}', [ImageController::class, 'store']);
                
    Route::post('/images', [ProfileController::class, 'storeImage'])->name('instructor.image');   
});