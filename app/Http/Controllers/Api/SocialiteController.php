<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BaseResource;
use App\Models\User;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    protected function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();
        $user = User::updateOrCreate([
            'provider_id' => $socialUser->id,
            'provider' => $provider,
        ], [
            'name' => $socialUser->nickname,
            'email' => $socialUser->email,
            'provider_token' => $socialUser->token,
        ]);
        $token = $user->createToken('Rozkop')->plainTextToken;

        return BaseResource::make([
            'user' => $user,
            'token' => $token,
        ]);
    }
}
