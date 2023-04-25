<?php

namespace App\Services;

use App\Http\Resources\CommunityResource;
use App\Models\Community;

class CommunityService
{
    public function showCommunity(string $id): CommunityResource
    {
        $community = Community::where('id', $id)->firstOrFail();

        return CommunityResource::make($community);
    }

    public function storeCommunity(string $name, string $description): CommunityResource
    {
        $user_id = auth('sanctum')->id();

        $community = Community::create([
            'name' => $name,
            'description' => $description,
            'user_id' => $user_id,
        ]);

        return CommunityResource::make($community);
    }

    public function updateCommunity(string $name, string $description, string $id): CommunityResource
    {
        $user_id = auth('sanctum')->id();

        $community = Community::find($id);
        $community->update([
            'name' => $name,
            'description' => $description,
            'user_id' => $user_id,
        ]);

        return CommunityResource::make($community);
    }

    public function destroyCommunity(string $id)
    {
        $user_id = auth('sanctum')->id();
        $community = Community::where('id', $id)->where('user_id', $user_id);

        return $community->softDelete();
    }
}
