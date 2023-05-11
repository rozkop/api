<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Model;

class ReactionService
{
    public function react(Model $model,string $reaction): BaseResource
    {
            switch($reaction)
            {
                case 'like':
                    $model->toggleReaction('like');
                    $model->getReactions();
                    return BaseResource::make(['message' => 'Success']);
                case 'dislike':
                    $model->toggleReaction('dislike');
                    $model->getReactions();
                    return BaseResource::make(['message' => 'Success']);
                default:
                    return BaseResource::make(['message' => 'Bad reaction']);
            }

    }
}
