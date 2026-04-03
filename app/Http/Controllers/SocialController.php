<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function index($provider)
    {
        $user = Auth::user();

        if (!$user || !$user->provider_token) {
            return redirect()->route('login')->withErrors([
                'email' => __('No linked social account token was found.'),
            ]);
        }

        $provider_user = Socialite::driver($provider)->userFromToken($user->provider_token);

        return response()->json([
            'provider' => $provider,
            'profile' => $provider_user,
        ]);
    }
}
