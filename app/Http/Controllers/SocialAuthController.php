<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google authentication.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    /**
     * Handle Google callback.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->id)->first();
            
            if ($findUser) {
                Auth::login($findUser);
            } else {
                $newUser = User::updateOrCreate(
                    ['email' => $user->email],
                    [
                        'name' => $user->name,
                        'google_id' => $user->id,
                        'password' => bcrypt(rand(100000, 999999)), // Random password
                        'role'=> 'user'
                    ]
                );
                Auth::login($newUser);
            }
            
            // Log successful authentication
            Log::info('Google authentication successful for user: ' . $user->email);
            
            return redirect()->intended(route('products.index'));
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Google authentication error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Google login failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Redirect to GitHub authentication.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }
    
    /**
     * Handle GitHub callback.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGithubCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
            $findUser = User::where('github_id', $user->id)->first();
            
            if ($findUser) {
                Auth::login($findUser);
            } else {
                // GitHub doesn't always provide email
                $email = $user->email ?? $user->nickname . '@github.com';
               
                $newUser = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $user->name ?? $user->nickname,
                        'github_id' => $user->id,
                        'password' => bcrypt(rand(100000, 999999)), // Random password
                        'role' => 'user'
                    ]
                );
                Auth::login($newUser);
            }
            
            // Log successful authentication
            Log::info('GitHub authentication successful for user: ' . ($user->email ?? $user->nickname));
            
            return redirect()->intended(route('products.index'));
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('GitHub authentication error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'GitHub login failed: ' . $e->getMessage());
        }
    }
}