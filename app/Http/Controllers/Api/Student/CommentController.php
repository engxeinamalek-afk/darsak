<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Relation;
class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, $commentable_type, Model $commentable){
        $data= $request->validated();

        $comment= $commentable->comments()->create([
            'body' => $data['body'],
            'student_id' => $request->user()->id,
        ]);

        return response()->json([$comment]);
        
    }
}
