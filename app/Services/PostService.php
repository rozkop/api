<?php

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Models\Post;

class PostService
{
    public function storePost(string $title, string $text): PostResource
    {
        $user_id = auth('sanctum')->id();

        $post = Post::create([
            'title' => $title,
            'text' => $text,
            'user_id' => $user_id
        ]);

        return PostResource::make($post);
    }

    public function showPost(string $id): PostResource
    {
        $post = Post::where('id', $id)->firstOrFail();

        return PostResource::make($post);
    }

    public function updatePost(string $title, string $text, string $id): PostResource
    {
        $user_id = auth('sanctum')->id();

        $post = Post::find($id);
        $post->update([
            'title' => $title,
            'text' => $text,
            'user_id' => $user_id
        ]);

        return PostResource::make($post);
    }
}
