<?php

namespace App\Services;

use App\Http\Resources\CommunityResource;
use App\Models\Community;
use App\Models\User;

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
        $community = Community::where('id', $id)->firstOrFail();
        $community->update([
            'name' => $name,
            'description' => $description,
            Community::slugger($community),
        ]);

        return CommunityResource::make($community);
    }

    public function destroyCommunity(string $id)
    {

        return Community::where('id', $id)->firstOrFail()->delete();
    }

    public function addFavourite(VotingService $votingService, Community $community): CommunityResource
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
        $votingService->upVote($user, $community, 'Favourite');
        $community->update(
            [
                'rating' => $community->viaLoveReactant()->getReactionTotal()->getWeight(),
            ]
        );

        return CommunityResource::make($community);
    }

    public function removeFavourite(VotingService $votingService, Community $community): CommunityResource
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();
        $votingService->removeReaction($user, $community, 'Favourite');
        $community->update(
            [
                'favourite_count' => $community->viaLoveReactant()->getReactionTotal()->getCount(),
            ]
        );

        return CommunityResource::make($community);
    }
}
