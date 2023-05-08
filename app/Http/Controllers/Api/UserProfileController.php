<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserProfileService;

class UserProfileController extends Controller
{
    public function show(): UserResource
    {
        $user_id = auth('sanctum')->id();
        $user = User::where('id', $user_id)->firstOrFail();

        return UserResource::make($user);
    }

    public function update(UserRequest $request, UserProfileService $service): BaseResource
    {
        return $service->updateUser($request);
    }

    public function destroy(UserProfileService $service, User $user): BaseResource
    {
        return $service->destroyUser($user);
    }

    public function giveModerator(UserProfileService $service, User $user): BaseResource
    {
        return $service->giveModeratorRole($user);
    }

    public function removeModerator(UserProfileService $service, User $user): BaseResource
    {
        return $service->removeModeratorRole($user);
    }
}
