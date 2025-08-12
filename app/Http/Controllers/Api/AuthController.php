<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login user and create token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Create token
        $token = $user->createToken('auth-token')->plainTextToken;

        // Check user type
        $userType = 'user'; // default
        if ($user->isSeller()) {
            $userType = 'seller';
        } elseif ($user->delivery) {
            $userType = 'delivery';
        }

        return response()->json([
            'message' => 'Login successful',
            'user' => $user->load(['seller', 'delivery']),
            'user_type' => $userType,
            'token' => $token,
        ], 200);
    }

    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,user',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Create token for new user
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'user_type' => 'user',
            'token' => $token,
        ], 201);
    }

    /**
     * Logout user (revoke token)
     */
    public function logout(Request $request)
    {
        try {
            // Get the current user
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Get current access token
            $currentToken = $user->currentAccessToken();
            
            if ($currentToken) {
                // Delete the current token
                $currentToken->delete();
                
                return response()->json([
                    'message' => 'Logged out successfully'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'No active session found'
                ], 400);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout from all devices (revoke all tokens)
     */
    public function logoutAll(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Delete all tokens for this user
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Logged out from all devices successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user info
     */
    public function me(Request $request)
    {
        try {
            // Get the authenticated user
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Load relationships with error handling
            try {
                $user->load(['seller', 'delivery']);
            } catch (\Exception $e) {
                // If relationships fail to load, continue without them
                \Log::warning('Failed to load user relationships: ' . $e->getMessage());
            }
            
            // Determine user type with safer checks
            $userType = 'user'; // default
            
            try {
                if (method_exists($user, 'isSeller') && $user->isSeller()) {
                    $userType = 'seller';
                } elseif ($user->delivery) {
                    $userType = 'delivery';
                }
            } catch (\Exception $e) {
                // If user type determination fails, stick with default
                \Log::warning('Failed to determine user type: ' . $e->getMessage());
            }

            return response()->json([
                'user' => $user,
                'user_type' => $userType,
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve user information',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}