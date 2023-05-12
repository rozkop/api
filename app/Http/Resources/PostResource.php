<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => ['id' => $this->user->id, 'name' => $this->user->name],
            'rating' => $this->rating,
            'community' => new CommunityResource($this->community),
            'count_comments' => CommentResource::collection($this->comments)->count(),
            'created_at' => $this->created_at,
            'slug' => $this->slug,
            'title' => $this->title,
            'text' => $this->text,
            'is_user_reacting' => $this->isUserReacting(),
        ];
    }
}
