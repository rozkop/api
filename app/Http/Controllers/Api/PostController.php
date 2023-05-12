<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\PostResource;
use App\Models\Community;
use App\Models\Post;
use App\Services\AdminService;
use App\Services\PostService;
use App\Services\ReactionService;

class PostController extends Controller
{
    public function showPosts($sortField= '')
    {
        switch ($sortField) {
            case 'hot' && '':
                return  PostResource::collection(Post::orderBy('rating', 'desc')->get()->paginate(15));

            case 'new':
                return  PostResource::collection(Post::orderBy('created_at', 'desc')->get()->paginate(15));
            }
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

    public function showReported(AdminService $service)
    {
        return $service->getReportedPosts();
    }
}
