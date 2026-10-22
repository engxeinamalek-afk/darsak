<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachTagRequest;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;

class TagController extends Controller
{
    public function attach(AttachTagRequest $request,$taggable_type, Model $taggable)
    {
        $tagsIds = $request->validated()['tags'];
        
        $taggable->tags()->syncWithoutDetaching($tagsIds);

        return response()->json([$tagsIds]);
    }

    public function store(StoreTagRequest $request){
        $data= $request->validated();

        $tag=Tag::create(['name' => $data['name']]);

        return \response()->json([$tag]);
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

        return new TagResource($tag);

    }

}
