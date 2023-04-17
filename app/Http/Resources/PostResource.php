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
            'user_id' => $this->user-> id,
            'community_id' => $this -> community->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'text' => $this->text,
            'rating' => $this->rating,
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
