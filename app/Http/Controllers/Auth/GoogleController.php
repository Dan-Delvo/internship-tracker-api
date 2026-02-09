<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;

class GoogleController extends Controller
{
    //

    public function redirectToGoogle() {
        return Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
    }

    public function handleGoogleCallback() {
        try{

            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::account($googleUser);
            $token = $user->createToken('google-auth-token')->plainTextToken;

            return response()->json([
                'status'    => "success",
                'user'      => $user,
                'token'     => $token
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Authentication Failed.',
                'google_error' => $e->getMessage(),
                ],
                 401
            );
        }

    }
}
