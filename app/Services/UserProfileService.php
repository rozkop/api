<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\CommunityResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Community;
use App\Models\Post;
use App\Models\User;

class UserProfileService
{
    public function showUser()
    {
        $user = User::where('id', auth('sanctum')->id())->firstOrFail();

        $owned_posts = PostResource::collection(Post::where('user_id', $user->id)->get());
        $owned_communities = CommunityResource::collection(Community::where('user_id', $user->id)->get());

        $liked_posts = PostResource::collection(Post::whereReactedBy()->get());
        $liked_communities = CommunityResource::collection(Community::whereReactedBy()->get());

        return BaseResource::make([
            'user' => UserResource::make($user),
            'user_posts' => $owned_posts,
            'user_communities' => $owned_communities,
            'user_liked_posts' => $liked_posts,
            'user_liked_communities' => $liked_communities,
        ]);
    }

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
                    $User = User::where('id', $user_id)->first();
                    $User->country = $inputValue;
                    $User->save();
                    break;
                case 'gender':
                    $User = User::where('id', $user_id)->first();
                    $User->gender = $inputValue;
                    $User->save();
                    break;
                case 'avatar':
                    $User = User::where('id', $user_id)->first();
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
