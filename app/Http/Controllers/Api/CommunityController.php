<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommunityRequest;
use App\Http\Resources\CommunityResource;
use App\Models\Community;
use App\Services\CommunityService;
use App\Services\ReactionService;

class CommunityController extends Controller
{
    public function index()
    {
        return Community::select('id', 'name')->get();
    }

    public function show(CommunityService $service, Community $community, $sortField = '')
    {
        return $service->showCommunity($community->id, $sortField);
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

    public function react(ReactionService $service, Community $community)
    {
        return $service->react($community, 'like');
    }


    public function destroy(Community $community, CommunityService $service)
    {
        $this->authorize('delete', $community);

        return $service->destroyCommunity($community->id);
    }
}
