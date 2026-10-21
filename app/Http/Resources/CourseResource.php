<?php

namespace App\Http\Resources;

use App\Enums\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();
        return [
            'id'   => $this->id,
            'name' => $this->name,
            
            'status'=> $this->when(
                $user && $user->role === UserRoles::INSTRUCTOR,
                $this->status
            ),

            'instructor_id' => $this->when(
                $user && $user->role === UserRoles::STUDENT, 
                $this->instructor_id
            ),
            'lessons' => LessonResource::collection($this->whenLoaded('lessons'))
        ];
    }
}
