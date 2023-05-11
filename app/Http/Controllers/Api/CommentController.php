<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use App\Services\ReactionService;

class CommentController extends Controller
{
    public function store(CommentService $service, CommentRequest $request, Post $post)
    {
        return $service->storeComment($request->text, $post);
    }

    public function react(ReactionService $service, Post $post, Comment $comment)
    {
        return $service->react($comment);
    }

    public function destroy(Comment $comment, CommentService $service)
    {
        $this->authorize('delete', $comment);

        return $service->destroyComment($comment->id);
    }
}
