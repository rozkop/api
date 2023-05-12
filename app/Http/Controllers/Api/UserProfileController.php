<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\BaseResource;
use App\Models\User;
use App\Services\AdminService;
use App\Services\UserProfileService;

class UserProfileController extends Controller
{
    public function show(UserProfileService $service)
    {
        return $service->showUser();
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

    public function getList(AdminService $service)
    {
        return $service->getUsersList();
    }
}
