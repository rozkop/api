<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function delete(User $user, Comment $comment): bool
    {
        if ($user->id === $comment->user_id || $user->can('delete any comment')) {
            return true;
        } else {
            return false;
        }
    }
}
