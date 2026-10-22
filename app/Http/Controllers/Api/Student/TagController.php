<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use ApiResponse;
    public function show(Tag $tag){
        $studentId = auth()->id(); 
        $tag->loadRelationsForStudent($studentId);
        return $this->successResponse(new TagResource($tag),"Tag retrieved successfully");
    }
}
