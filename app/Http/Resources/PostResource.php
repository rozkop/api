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
            'user_name' => $this->user->name,
            'rating' => $this->rating,
            'created_at' => $this-> created_at,
            'community_name' => $this->community->name,
            'slug' => $this->slug,
            'title' => $this->title,
            'text' => $this->text,
            'comments' => CommentResource::collection($this->comments),
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
