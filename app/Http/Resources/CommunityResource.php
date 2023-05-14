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
            'rating' => $this->rating,
            'user' => ['id' => $this->user->id, 'name' => $this->user->name],
            'slug' => $this->slug,
            'name' => $this->name,
            'color' => $this->color,
            'description' => $this->description,
            'is_user_reacting' => $this->isUserReacting(),

        ];
    }
}
