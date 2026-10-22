<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachTagRequest;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Model;

class TagController extends Controller
{
    use ApiResponse;
    public function attach(AttachTagRequest $request,$taggable_type, Model $taggable)
    {
        $tagsIds = $request->validated()['tags'];
        
        $taggable->tags()->syncWithoutDetaching($tagsIds);

        return $this->successResponse($tagsIds, "Tags assigned successfully");
    }

    public function store(StoreTagRequest $request){
        $data= $request->validated();

        $tag=Tag::create(['name' => $data['name']]);

        return $this->successResponse($tag, "Tag created successfully", 201);
    }
    public function show(Tag $tag){
        $tag->load([
            'courses' => function ($query) {
                $query->select('courses.id', 'courses.name', 'courses.status')
                    ->withoutGlobalScopes();
            },  
            'lessons:id,name,url',   
            'tasks:id,name,body'   
        ]);

        return $this->successResponse(new TagResource($tag), "Tag retrieved successfully");
    }

}
