<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use App\Services\UserProfileService;

class UserProfileController extends Controller
{
    public function show(): ProfileResource
    {
        $user_id = auth('sanctum')->id();
        $user = User::where('id', $user_id)->firstOrFail();

        return ProfileResource::make($user);
    }

    public function update(ProfileRequest $request, UserProfileService $service): BaseResource
    {
        return $service->updateUser($request);
    }

    public function destroy(): BaseResource
    {
        $user_id = auth('sanctum')->id();
        $user = User::where('id', $user_id)->first();
        $user->delete();

        return BaseResource::make(['message' => 'Profile deleted successfully!']);
    }
}
