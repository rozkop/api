<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
       return Socialite::driver($provider)->stateless()->redirect();
    }

    protected function callback($provider)
    {
      $user = Socialite::driver($provider)->stateless()->user();
      dd($user);
    }
}
