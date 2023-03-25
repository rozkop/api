<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    public function store(PostRequest $request, PostService $service)
    {
        return $service->storePost($request->title, $request->text);
    }

    public function show(string $username, string $id, string $slug): PostResource
    {
        $user = User::where('name', $username)->firstOrFail();

        $post = Post::where('user_id', $user->id)
            ->where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();

        return PostResource::make($post);
    }

    public function update(PostRequest $request, string $id, PostService $service): PostResource
    {
        return $service->updatePost($request->title, $request->text, $id);
    }

    public function destroy(string $id)
    {
        $user_id = auth('sanctum')->id();

        $post = Post::where('user_id', $user_id)->where('id', $id);
        $post->delete();
    }
}
