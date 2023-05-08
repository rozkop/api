<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use App\Services\VotingService;

class PostController extends Controller
{
    public function hotSort()
    {
        return PostResource::collection(Post::get()->paginate());
    }

    public function newSort()
    {
        return PostResource::collection(Post::get()->paginate());
    }

    public function store(PostRequest $request, PostService $service)
    {
        return $service->storePost($request->title, $request->text, $request->community_id);
    }

    public function show(Post $post, PostService $service): PostResource
    {
        return $service->showPost($post->id);
    }

    public function update(PostRequest $request, Post $post, PostService $service): PostResource
    {
        $this->authorize('update', $post);

        return $service->updatePost($request->title, $request->text, $post->id);
    }

    public function upVote(VotingService $service, Post $post)
    {
        return $service->vote($post, 'Like');
    }

    public function downVote(VotingService $service, Post $post)
    {
        return $service->vote($post, 'Dislike');
    }

    public function removeLike(VotingService $service, Post $post)
    {
        return $service->removeReaction($post, 'Like');
    }

    public function removeDislike(VotingService $service, Post $post)
    {
        return $service->removeReaction($post, 'Dislike');
    }

    public function destroy(Post $post, PostService $service)
    {
        $this->authorize('delete', $post);

        return $service->destroyPost($post->id);
    }
}
