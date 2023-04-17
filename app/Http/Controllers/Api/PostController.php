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
        return PostResource::collection(Post::orderBy('rating', 'desc')->paginate())->response()->getData(true);
    }

    public function newSort()
    {
        return PostResource::collection(Post::orderBy('created_at')->paginate())->response()->getData(true);
    }

    public function store(PostRequest $request, PostService $service)
    {
        return $service->storePost($request->title, $request->text);
    }

    public function show(string $id, PostService $service): PostResource
    {
        return $service->showPost($id);
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
