<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
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
        // dd($socialUser);
        $user = User::updateOrCreate([
            'provider_id' => $socialUser->id,
            'provider' => $provider,
        ], [
            'name' => $socialUser->nickname,
            'email' => $socialUser->email,
            'provider_token' => $socialUser->token,
        ]);
        Auth::login($user);

        return redirect('/api');
    }
}
