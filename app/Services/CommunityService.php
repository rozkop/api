<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Http\Resources\CommunityResource;
use App\Http\Resources\PostResource;
use App\Models\Community;
use App\Models\Post;

class CommunityService
{
    public function showCommunity(string $id, $sortField = '')
    {
        $community = Community::where('id', $id)->firstOrFail();
        switch ($sortField) {
            case 'hot':

                $posts = PostResource::collection(Post::where('community_id', $id)->orderBy('rating', 'desc')->get()->paginate(15));

                return BaseResource::collection(['Community' => new CommunityResource($community), 'Posts' => $posts]);

            case 'new':

                $posts = PostResource::collection(Post::where('community_id', $id)->orderBy('created_at', 'desc')->get()->paginate(15));

                return BaseResource::collection(['Community' => new CommunityResource($community), 'Posts' => $posts]);

            default:
                $posts = PostResource::collection(Post::where('community_id', $id)->orderBy('rating', 'desc')->get()->paginate(15));

                return BaseResource::collection(['Community' => new CommunityResource($community), 'Posts' => $posts]);

        }

    }

    public function storeCommunity(string $name, string $description, string $color): CommunityResource
    {
        $user_id = auth('sanctum')->id();

        $community = Community::create([
            'name' => $name,
            'description' => $description,
            'user_id' => $user_id,
            'color' => $color,
        ]);

        return CommunityResource::make($community);
    }

    public function updateCommunity(string $name, string $description, string $color, string $id): CommunityResource
    {
        $community = Community::where('id', $id)->firstOrFail();
        $community->update([
            'name' => $name,
            'description' => $description,
            'color' => $color,
            Community::slugger($community),
        ]);

        return CommunityResource::make($community);
    }

    public function destroyCommunity(string $id): BaseResource
    {
        Community::where('id', $id)->firstOrFail()->delete();

        return BaseResource::make(['message' => 'Deleted successfully']);
    }
}
