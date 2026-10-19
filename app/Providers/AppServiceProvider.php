<?php

namespace App\Providers;

use App\Enums\ImageableType;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Services\ImagesUpload\UploadServiceInterface;
use App\Services\ImagesUpload\LocalUploadService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Enums\TaggableType;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 
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
        Route::bind('taggable', function ($value, $route) {
            $typeString = $route->parameter('taggable_type');
            
            $taggableType = TaggableType::tryFrom($typeString);
            
            if (! $taggableType) {
                abort(422, "This resource cannot be tagged.");
            }

            $modelClass = Relation::getMorphedModel($taggableType->value);
            
            return $modelClass::findOrFail($value);
        });

        Route::bind('imageable', function ($value, $route) {
            $typeString = $route->parameter('imageable_type');
            $imageableType = ImageableType::tryFrom($typeString);
            
            $allowedTypes = [ImageableType::COURSE, ImageableType::LESSON];

            if (! $imageableType || ! in_array($imageableType, $allowedTypes, true)) {
                abort(422, "This resource cannot have dynamic images.");
            }

            $modelClass = Relation::getMorphedModel($imageableType->value);
            return $modelClass::findOrFail($value);
        });
    }
}
