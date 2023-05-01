<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function store(CommentRequest $request, CommentService $service, Post $post)
    {
        return $service->storeComment($request->text, $post);
    }

    public function update(CommentRequest $request, CommentService $service, Comment $comment): CommentResource
    {
        $this->authorize('update', $comment);

        return $service->updateComment($request->text, $comment->id);
    }

    public function destroy(Comment $comment, CommentService $service)
    {
        $this->authorize('delete', $comment);

        return $service->destroyComment($comment->id);
    }
}
