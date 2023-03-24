<?php

namespace App\Services;

use App\Http\Requests\ProfileRequest;
use App\Http\Resources\BaseResource;
use App\Models\User;
use App\Models\UserInfo;

class UserProfileService
{
    public function updateUser(ProfileRequest $request): BaseResource
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
                    $userInfo = UserInfo::where('user_id', $user_id)->first();
                    $userInfo->country = $inputValue;
                    $userInfo->save();
                    break;
                case 'gender':
                    $userInfo = UserInfo::where('user_id', $user_id)->first();
                    $userInfo->gender = $inputValue;
                    $userInfo->save();
                    break;
                default:
                    break;
            }
        }

        return BaseResource::make(['message' => 'Updated successfully!']);
    }
}
