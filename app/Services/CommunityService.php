<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Http\Resources\byHotCommunity;
use App\Http\Resources\byNewCommunity;
use App\Http\Resources\CommunityResource;
use App\Models\Community;


class CommunityService
{
    public function showCommunityByNew(string $id): byNewCommunity
    {
        $community = Community::where('id', $id)->firstOrFail();
        return  new byNewCommunity($community);

    }
    public function showCommunityByHot(string $id): byHotCommunity
    {
        $community = Community::where('id', $id)->firstOrFail();
        return  new byHotCommunity($community);

    }

    public function searchCommunity(string $input)
    {
        $communities = Community::query()
            ->where('name', 'LIKE', "%" . $input . "%") 
            ->get();
        return CommunityResource::collection($communities);
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
        $community = Community::where('id', $id)->firstOrFail();
        $community->update([
            'name' => $name,
            'description' => $description,
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
