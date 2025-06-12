<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_image = $path;
            $user->save();
            
            return Redirect::route('profile.edit')->with('status', 'Profile photo updated successfully!');
        }
        
        // Handle name update
        if ($request->has('name')) {
            $user->name = $request->name;
            
            if ($user->isDirty('name')) {
                $user->save();
                return Redirect::route('profile.edit')->with('status', 'Username updated successfully!');
            }
        }
        
        // Handle email update (only for non-social users)
        if ($request->has('email') && !$user->google_id && !$user->github_id) {
            $user->email = $request->email;
            
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
                $user->save();
                return Redirect::route('profile.edit')->with('status', 'Email updated successfully! Please verify your new email address.');
            }
        }
        
        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // Check if user is social login user
        if ($user->google_id || $user->github_id) {
            return Redirect::route('profile.edit')->withErrors(['password' => 'Cannot change password for social login accounts.']);
        }
        
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Explicitly use bcrypt for password hashing
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return Redirect::route('profile.edit')->with('status', 'Password updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // For social login users, no password verification needed
        if (!$user->google_id && !$user->github_id) {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);
        }

        // Delete profile photo if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'Account deleted successfully.');
    }
}