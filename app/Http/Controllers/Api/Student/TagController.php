<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tag){
        $studentId = auth()->id(); 
        $tag->loadRelationsForStudent($studentId);
        return new TagResource($tag);

    }
}
