<?php

namespace App\Providers;

use App\Enums\CommentableType;
use App\Enums\ImageableType;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Services\ImagesUpload\UploadServiceInterface;
use App\Services\ImagesUpload\LocalUploadService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Enums\TaggableType;
use App\Models\Course;
use App\Models\Scopes\PublishedCoursesScope;
use App\Routing\PolymorphicBinder;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UploadServiceInterface::class, LocalUploadService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'course'  => \App\Models\Course::class,
            'lesson'  => \App\Models\Lesson::class,
            'instructor' => \App\Models\User::class, 
            'task' => \App\Models\Task::class
        ]);

        Route::bind('taggable', PolymorphicBinder::bind(
            paramName: 'taggable', 
            enumClass: TaggableType::class, 
            allowedTypes: [], 
            withoutGlobalScopes: ['course' => [PublishedCoursesScope::class]] 
        ));

        Route::bind('imageable', PolymorphicBinder::bind(
            paramName: 'imageable', 
            enumClass: ImageableType::class, 
            allowedTypes: [ImageableType::COURSE, ImageableType::LESSON], 
            withoutGlobalScopes: ['course' => [PublishedCoursesScope::class]]
        ));

        Route::bind('commentable', PolymorphicBinder::bind(
            paramName: 'commentable', 
            enumClass: CommentableType::class
        ));

        Route::bind('instructor_course', function ($value) {
            return Course::withoutGlobalScope(PublishedCoursesScope::class)
                ->findOrFail($value);
        });
    }
}
