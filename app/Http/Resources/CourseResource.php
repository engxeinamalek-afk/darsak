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
            
            $this->mergeWhen($user && $user->role === UserRoles::INSTRUCTOR, [
                'status' => $this->status
            ]),

            $this->mergeWhen($user && $user->role === UserRoles::STUDENT, [
                'status' => $this->status
            ]),
            'lessons' => LessonResource::collection($this->whenLoaded('lessons'))
        ];
    }
}
