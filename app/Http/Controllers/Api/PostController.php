<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    public function hotSort()
    {
        return PostResource::collection(Post::orderBy('rating', 'desc')->paginate(15)->links());
    }

    public function newSort()
    {
        return PostResource::collection(Post::orderBy('created_at', 'asc')->paginate(15)->links());
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

    public function destroy(Post $post, PostService $service)
    {
        $this->authorize('delete', $post);

        return $service->destroyPost($post->id);
    }
}
