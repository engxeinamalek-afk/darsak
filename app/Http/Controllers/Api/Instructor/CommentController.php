<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetCommentsRequest;
use App\Http\Resources\CommentResourse;
use Illuminate\Http\Request;
use App\Models\Comment;


class CommentController extends Controller
{
    public function index(GetCommentsRequest $request)
    {
        $limit = $request->validated()['limit'];

        $comments = Comment::query()->select(['id','body','created_at',
                                             'student_id', 'commentable_id',
                                              'commentable_type'])
                                            ->with(['student:id,name', 'commentable:id,name'])
                                            ->latest() 
                                            ->limit($limit) 
                                            ->get();

        return CommentResourse::collection($comments);
    }

}
