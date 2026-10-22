<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResourse;
use App\Models\Comment;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Relation;
class CommentController extends Controller
{
    use ApiResponse;
    public function store(StoreCommentRequest $request, $commentable_type, Model $commentable){
        $data= $request->validated();

        $comment= $commentable->comments()->create([
            'body' => $data['body'],
            'student_id' => $request->user()->id,
        ]);

        return $this->successResponse(new CommentResourse($comment),"Comment created successfully", 201);
        
    }
}
