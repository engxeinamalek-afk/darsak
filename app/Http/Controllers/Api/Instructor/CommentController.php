<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetCommentsRequest;
use App\Http\Resources\CommentResourse;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Traits\ApiResponse;

class CommentController extends Controller
{
    use ApiResponse;
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
        return $this->successResponse(CommentResourse::collection($comments),
                                     'Comments retrieved successfully');
    }

}
