<?php

namespace App\Services;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\User;

class CommentService
{
    public function storeComment(string $text, string $comment_id): CommentResource
    {
        $user_id = auth('sanctum')->id();

        $comment = Comment::create([
            'text' => $text,
            'post_id' => $comment_id,
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

    public function vote(VotingService $votingService, Comment $comment, string $reaction): CommentResource
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
        $votingService->vote($user, $comment, $reaction);

        $comment->update(
            [
                'rating' => $comment->viaLoveReactant()->getReactionTotal()->getWeight(),
            ]
        );

        return CommentResource::make($comment);
    }

    public function removeVote(VotingService $votingService, Comment $comment, string $reaction): CommentResource
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
        $votingService->removeReaction($user, $comment, $reaction);

        $comment->update(
            [
                'rating' => $comment->viaLoveReactant()->getReactionTotal()->getWeight(),
            ]
        );

        return CommentResource::make($comment);
    }
}
