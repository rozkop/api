<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommunityRequest;
use App\Http\Resources\CommunityResource;
use App\Services\CommunityService;

class CommunityController extends Controller
{
    public function store(CommunityRequest $request, CommunityService $service)
    {
        return $service->storeCommunity($request->name, $request->description);
    }

    public function show(CommunityService $community, string $id): CommunityResource
    {
        return $community->showCommunity($id);
    }

    public function update(CommunityRequest $request, CommunityService $service, string $id): CommunityResource
    {
        return $service->updateCommunity($request->name, $request->description, $id);
    }
    // public function destroy(string $id, CommunityService $service)
    // {
    //     return $service->destroyCommunity($id);
    // }
}
