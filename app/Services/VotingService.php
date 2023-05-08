<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class VotingService
{
    public function vote(Model $model, string $reaction): BaseResource
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
        $reacterFacade = $user->viaLoveReacter();

        if ($reacterFacade->hasNotReactedTo($model)) {
            $reacterFacade->reactTo($model, $reaction);
            $model->update([$model->ratingUpdate($model)]);

            return BaseResource::make(['message' => 'Reacted successfully']);
        } else {
            return BaseResource::make(['error' => 'Already reacted']);
        }
    }

    public function removeReaction(Model $model, string $reaction)
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
        $reacterFacade = $user->viaLoveReacter();

        if ($reacterFacade->hasReactedTo($model)) {
            $reacterFacade->unreactTo($model, $reaction);
            $model->update([$model->ratingUpdate($model)]);

            return BaseResource::make(['message' => 'Reaction removed successfully']);
        } else {
            return BaseResource::make(['error' => 'Not reacted']);
        }
    }
}
