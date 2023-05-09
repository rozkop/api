<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommunityRequest;
use App\Http\Resources\byHotCommunity;
use App\Http\Resources\byNewCommunity;
use App\Http\Resources\CommunityByNewResourceCollection;
use App\Http\Resources\CommunityResource;
use App\Models\Community;
use App\Services\CommunityService;
use App\Services\VotingService;

class CommunityController extends Controller
{
    public function index()
    {
        return Community::select('id', 'name')->get();
    }

    public function showByNew(CommunityService $service, Community $community): byNewCommunity
    {
        return $service->showCommunityByNew($community->id);
    }
    public function showByHot(CommunityService $service, Community $community): byHotCommunity
    {
        return $service->showCommunityByHot($community->id);
    }

    public function search(CommunityService $service, string $input)
    {
        return $service->searchCommunity($input);
    }
    public function store(CommunityRequest $request, CommunityService $service)
    {
        return $service->storeCommunity($request->name, $request->description);
    }

    public function update(CommunityRequest $request, CommunityService $service, Community $community): CommunityResource
    {
        $this->authorize('update', $community);

        return $service->updateCommunity($request->name, $request->description, $community->id);
    }

    public function addFavourite(VotingService $service, Community $community)
    {
        return $service->vote($community, 'Like');
    }

    public function removeFavorite(VotingService $service, Community $community)
    {
        return $service->removeReaction($community, 'Like');
    }

    public function destroy(Community $community, CommunityService $service)
    {
        $this->authorize('delete', $community);

        return $service->destroyCommunity($community->id);
    }
}
