<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'favourite_count' => $this->favourite_count,
            'user' => new UserResource($this->user),
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'posts' => PostResource::collection($this->posts),

        ];
    }
}
