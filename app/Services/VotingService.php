<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class VotingService
{
    public function upVote(User $user, Model $model, string $reaction)
    {
        $reacterFacade = $user->viaLoveReacter();

        if ($reacterFacade->hasNotReactedTo($model)) {
            return $reacterFacade->reactTo($model, $reaction);
        } else {
            return response()->json(
                [
                    'message' => 'User already reacted to this',
                ],
                403
            );
        }
    }

    public function downVote(User $user, Model $model, string $reaction)
    {
        $reacterFacade = $user->viaLoveReacter();

        if ($reacterFacade->hasNotReactedTo($model)) {
            return $reacterFacade->reactTo($model, $reaction);
        } else {
            return response()->json(
                [
                    'message' => 'User already reacted to this',
                ],
                403
            );
        }
    }

    public function removeReaction(User $user, Model $model, string $reaction)
    {
        $reacterFacade = $user->viaLoveReacter();

        if ($reacterFacade->hasReactedTo($model)) {
            return $reacterFacade->unreactTo($model, $reaction);
        } else {
            return response()->json(
                [
                    'message' => 'User do not reacted to this',
                ],
                403
            );
        }
    }
}
