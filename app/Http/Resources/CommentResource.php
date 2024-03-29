<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'post_id' => $this->post->id,
            'user' => ['id' => $this->user->id, 'name' => $this->user->name],
            'text' => $this->text,
            'rating' => $this->rating,
            'is_user_reacting' => $this->isUserReacting(),
        ];
    }
}
