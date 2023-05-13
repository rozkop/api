<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class EmailVerificationController extends Controller
{
    public function verify($id, $hash)
    {
        $user = User::find($id);

        abort_if(! $user, 403);

        abort_if(! hash_equals(sha1($user->getEmailForVerification()), $hash), 403);

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            event(new Verified($user));
        }

        return BaseResource::make(['messege' => 'Success']);
    }
}
