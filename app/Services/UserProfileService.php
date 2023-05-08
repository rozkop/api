<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Http\Resources\BaseResource;
use App\Models\User;

class UserProfileService
{
    public function updateUser(UserRequest $request): BaseResource
    {
        $user_id = auth('sanctum')->id();

        foreach ($request->all() as $inputName => $inputValue) {
            switch ($inputName) {
                case 'password':
                    $user = User::where('id', $user_id)->first();
                    $user->password = bcrypt($inputValue);
                    $user->save();
                    break;
                case 'country':
                    $User = User::where('user_id', $user_id)->first();
                    $User->country = $inputValue;
                    $User->save();
                    break;
                case 'gender':
                    $User = User::where('user_id', $user_id)->first();
                    $User->gender = $inputValue;
                    $User->save();
                    break;
                case 'avatar':
                    $User = User::where('user_id', $user_id)->first();
                    $User->avatar = $inputValue;
                    $User->save();
                default:
                    break;
            }
        }

        return BaseResource::make(['message' => 'Updated successfully!']);
    }

    public function giveModeratorRole(User $user): BaseResource
    {
        if ($user->hasRole('moderator')) {
            return BaseResource::make(['message' => 'User is already moderator!']);
        } else {
            $user->assignRole('moderator');

            return BaseResource::make(['message' => 'Assign successfully!']);
        }
    }

    public function removeModeratorRole(User $user): BaseResource
    {
        if ($user->hasRole('moderator')) {
            $user->removeRole('moderator');

            return BaseResource::make(['message' => 'Removed successfully!']);
        } else {
            return BaseResource::make(['message' => 'User is not a moderator!']);
        }
    }

    public function destroyUser(User $user): BaseResource
    {
        $user->firstOrFail()->delete();

        return BaseResource::make(['message' => 'Deleted successfully']);
    }
}
