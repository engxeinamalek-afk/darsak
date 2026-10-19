<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachTagRequest;
use Illuminate\Database\Eloquent\Model;

class TagController extends Controller
{
    public function attach(AttachTagRequest $request,$taggable_type, Model $taggable)
    {

        $tagsIds = $request->validated()['tags'];
        
        $taggable->tags()->syncWithoutDetaching($tagsIds);

        return response()->json([$tagsIds]);
    }

}
