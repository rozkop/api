<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;

class PostService
{
    public function showPost(string $id,)
    {
        $post = Post::where('id', $id)->firstOrFail();
        $comments = [Comment::where('post_id', $id)->get() ];
        if(auth('sanctum')->user())
        {
            $reacted = $post->reacted()->type;
        }
        else $reacted = 'No login user';

        return BaseResource::collection(['Post' => new PostResource($post), 'is reacted by user' => $reacted, 'Comments' => $comments]);
    }

    public function storePost(string $title, string $text, Community $community): PostResource
    {
        $user_id = auth('sanctum')->id();

        $post = Post::create([
            'title' => $title,
            'text' => $text,
            'community_id' => $community->id,
            'user_id' => $user_id,

        ]);

        return PostResource::make($post);
    }

    public function updatePost(string $title, string $text, string $id): PostResource
    {
        $post = Post::where('id', $id)->firstOrFail();
        $post->update([
            'title' => $title,
            'text' => $text,
            Post::slugger($post),
        ]);

        return PostResource::make($post);
    }

    public function reportPost(string $id): BaseResource
    {
        $post = Post::where('id', $id)->firstOrFail();
        $post->update(['reports' => +1]);

        return BaseResource::make(['message' => 'Post reported successfully']);
    }

    public function destroyPost(string $id): BaseResource
    {
        Post::where('id', $id)->firstOrFail()->delete();

        return BaseResource::make(['message' => 'Deleted successfully']);
    }
}
