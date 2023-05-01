<?php

namespace App\Services;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\User;

class CommentService
{
    public function storeComment(string $text, string $post_id): CommentResource
    {
        $user_id = auth('sanctum')->id();

        $comment = Comment::create([
            'text' => $text,
            'post_id' => $post_id,
            'owner' => $user_id,
        ]);

        return CommentResource::make($comment);
    }

    public function updateComment(string $text, string $id): CommentResource
    {
        $comment = Comment::where('id', $id)->firstOrFail();
        $comment->update([

            'text' => $text,
            Comment::slugger($comment),
        ]);

        return CommentResource::make($comment);
    }

    public function destroyComment(string $id)
    {
        return Comment::where('id', $id)->firstOrFail()->delete();
    }

    public function upVote(VotingService $votingService, Comment $comment)
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
        $votingService->upVote($user, $comment);

        return $comment->update(
            [
                'rating' => $comment->viaLoveReactant()->getReactionTotal()->getWeight(),
            ]
        );
    }

    public function downVote(VotingService $votingService, Comment $comment)
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
        $votingService->downVote($user, $comment);

        return $comment->update(
            [
                'rating' => $comment->viaLoveReactant()->getReactionTotal()->getWeight(),
            ]
        );
    }
}
