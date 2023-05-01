<?php

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;

class PostService
{
    public function showPost(string $id): PostResource
    {
        $post = Post::where('id', $id)->firstOrFail();

        return PostResource::make($post);
    }

    public function storePost(string $title, string $text, string $community_id): PostResource
    {
        $user_id = auth('sanctum')->id();

        $post = Post::create([
            'title' => $title,
            'text' => $text,
            'community_id' => $community_id,
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

    public function destroyPost(string $id)
    {
        return Post::where('id', $id)->firstOrFail()->delete();
    }

    public function upVote(VotingService $votingService, Post $post): PostResource
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
        $votingService->upVote($user, $post, 'Like');
        $post->update(
            [
                'rating' => $post->viaLoveReactant()->getReactionTotal()->getWeight(),
            ]
        );

        return PostResource::make($post);
    }

    public function downVote(VotingService $votingService, Post $post): PostResource
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
        $votingService->downVote($user, $post, 'Dislike');
        $post->update(
            [
                'rating' => $post->viaLoveReactant()->getReactionTotal()->getWeight(),
            ]
        );

        return PostResource::make($post);
    }

    public function removeVote(VotingService $votingService, Post $post): PostResource
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
        $votingService->removeReaction($user, $post, 'Like|Dislike');
        $post->update(
            [
                'rating' => $post->viaLoveReactant()->getReactionTotal()->getWeight(),
            ]
        );

        return PostResource::make($post);
    }
}
