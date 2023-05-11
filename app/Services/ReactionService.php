<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Model;

class ReactionService
{
    public function react(Model $model): BaseResource
    {
            $model->toggleReaction('like');
            return BaseResource::make(['message' => 'Success']);
    }
}
