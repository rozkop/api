<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registerUser(string $email, string $name, string $password)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $token = $user->createToken('rozkop')->plainTextToken;

        return BaseResource::make([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function loginUser(string $email, string $password)
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return BaseResource::make(['error' => 'Invalid email or password!']);
        }

        $token = $user->createToken('rozkop')->plainTextToken;

        return BaseResource::make([
            'user' => $user,
            'token' => $token,
        ]);
    }
}
