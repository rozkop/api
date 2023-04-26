<?php

namespace App\Policies;

use App\Models\Community;
use App\Models\User;

class CommunityPolicy
{
    public function update(User $user, Community $community): bool
    {
        if ($user->id === $community->user_id || $user->can('edit any communities')) {
            return true;
        } else {
        return false;
        }
    }

    public function delete(User $user, Community $community): bool
    {
        if ($user->id === $community->user_id || $user->can('delete any communities')) {
            return true;
        } else {
        return false;
        }
    }

    public function restore(User $user, Community $community): bool
    {
        if ($user->can('restore anything')) {
            return true;
        } else {
        return false;
        }
    }
}
