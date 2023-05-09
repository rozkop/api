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
            'user' => $this->user->name,
            'avatar' => $this->user->avatar,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
            'community' => $this->community,
            'slug' => $this->slug,
            'title' => $this->title,
            'text' => $this->text,
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
