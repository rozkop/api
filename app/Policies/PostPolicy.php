<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function update(User $user, Post $post): bool
    {
        if ($user->id === $post->user_id || $user->can('edit any posts')) {
            return true;
        } else {
            return false;
        }
    }

    public function delete(User $user, Post $post): bool
    {
        if ($user->id === $post->user_id || $user->can('delete any posts')) {
            return true;
        } else {
            return false;
        }
    }

    public function restore(User $user, Post $post): bool
    {
        if ($user->can('restore anything')) {
            return true;
        } else {
            return false;
        }
    }
}
