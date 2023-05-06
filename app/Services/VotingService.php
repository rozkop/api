<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class VotingService
{
    public function vote(Model $model, string $reaction)
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
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

    public function removeReaction(Model $model, string $reaction)
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
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
