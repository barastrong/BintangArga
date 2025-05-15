<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google authentication.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver('google')->user();

            // Pastikan email tersedia
            if (!$socialUser->email) {
                return redirect()->route('login')->with('error', 'Google account does not have an email.');
            }

            $user = User::updateOrCreate(
                ['email' => $socialUser->email],
                [
                    'name'      => $socialUser->name,
                    'google_id' => $socialUser->id,
                    'password'  => bcrypt(Str::random(24)),
                    'role'      => 'user'
                ]
            );

            Auth::login($user);

            Log::info('Google authentication successful for user: ' . $socialUser->email);

            return redirect()->intended(route('products.index'));
        } catch (\Exception $e) {
            Log::error('Google authentication error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Google login failed: ' . $e->getMessage());
        }
    }

    /**
     * Redirect to GitHub authentication.
     */
    public function redirectToGithub(): RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Handle GitHub callback.
     */
    public function handleGithubCallback(): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver('github')->user();

            $email = $socialUser->email ?? $socialUser->nickname . '@github.com';

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'       => $socialUser->name ?? $socialUser->nickname,
                    'github_id'  => $socialUser->id,
                    'password'   => bcrypt(Str::random(24)),
                    'role'       => 'user'
                ]
            );

            Auth::login($user);

            Log::info('GitHub authentication successful for user: ' . $email);

            return redirect()->intended(route('products.index'));
        } catch (\Exception $e) {
            Log::error('GitHub authentication error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'GitHub login failed: ' . $e->getMessage());
        }
    }
}
