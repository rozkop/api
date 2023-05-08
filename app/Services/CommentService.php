<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Http\Resources\CommentResource;
use App\Models\Comment;

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

    public function destroyComment(string $id): BaseResource
    {
        Comment::where('id', $id)->firstOrFail()->delete();

        return BaseResource::make(['message' => 'Deleted successfully']);
    }
}
