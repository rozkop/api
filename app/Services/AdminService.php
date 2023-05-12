<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Http\Resources\CommunityResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AdminService
{
    public function getTrashedPosts()
    {
        $posts = Post::onlyTrashed()->get();

        return PostResource::collection($posts);
    }

    public function getTrashedCommunities()
    {
        $communities = Community::onlyTrashed()->get();

        return CommunityResource::collection($communities);
    }

    public function getTrashedUsers()
    {
        $users = User::onlyTrashed()->get();

        return UserResource::collection($users);
    }

    public function getReportedPosts()
    {
        $posts = Post::where('reports'.'>'. 0)->orderBy('rating', 'desc')->get();
        return PostResource::collection($posts);
    }

    public function getUsersList()
    {
        return UserResource::collection(User::get());
    }

    public function restoreTrashed(Model $model)
    {
        $model->withTrashed()->restore();

        return BaseResource::make(['message' => 'Recovered successfully']);
    }
}
