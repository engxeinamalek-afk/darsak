<?php

namespace App\Http\Resources;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'created_at' => $this->created_at,
            'target_type' => $this->commentable_type,
            'target_details' => $this->whenLoaded('commentable', function () {
                return match ($this->commentable_type) {
                    Course::class => new CourseResource($this->commentable),
                    Lesson::class => new LessonResource($this->commentable),
                    Task::class   => new TaskResource($this->commentable),
                    default       => $this->commentable, 
                };
            }),
        ];
    }
}
