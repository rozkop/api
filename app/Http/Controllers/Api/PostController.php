<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Community;
use App\Models\Post;
use App\Services\AdminService;
use App\Services\PostService;
use App\Services\ReactionService;

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

    public function store(PostRequest $request, PostService $service, Community $community)
    {
        return $service->storePost($request->title, $request->text, $community);
    }

    public function show(Post $post, PostService $service)
    {
        return $service->showPost($post->id);
    }

    public function update(PostRequest $request, Post $post, PostService $service): PostResource
    {
        $this->authorize('update', $post);

        return $service->updatePost($request->title, $request->text, $post->id);
    }

    public function react(ReactionService $service, Post $post, string $reaction)
    {
        return $service->react($post, $reaction);
    }

    public function destroy(Post $post, PostService $service)
    {
        $this->authorize('delete', $post);

        return $service->destroyPost($post->id);
    }

    public function report(Post $post, PostService $service)
    {
        return $service->reportPost($post->id);
    }

    public function showTrashed(AdminService $service)
    {
        return $service->getTrashedPosts();
    }
}
