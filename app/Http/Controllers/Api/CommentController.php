<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use App\Services\VotingService;

class CommentController extends Controller
{
    public function store(CommentRequest $request, CommentService $service, Post $post)
    {
        return $service->storeComment($request->text, $post);
    }

    public function upVote(VotingService $service, Comment $comment)
    {
        return $service->vote($comment, 'Like');
    }

    public function downVote(VotingService $service, Comment $comment)
    {
        return $service->vote($comment, 'Dislike');
    }

    public function removeVote(VotingService $service, Comment $comment)
    {
        return $service->removeReaction($comment, 'Favourite');
    }

    public function destroy(Comment $comment, CommentService $service)
    {
        $this->authorize('delete', $comment);

        return $service->destroyComment($comment->id);
    }
}
