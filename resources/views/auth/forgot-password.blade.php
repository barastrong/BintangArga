<x-guest-layout>
    <style>
        /* Change primary button color to orange */
        .bg-indigo-600 {
            background-color: rgb(234, 88, 12) !important; /* orange-600 */
        }
        .hover\:bg-indigo-700:hover {
            background-color: rgb(194, 65, 12) !important; /* orange-700 */
        }
        .focus\:ring-indigo-500:focus {
            --tw-ring-color: rgb(249, 115, 22) !important; /* orange-500 */
        }
        .focus\:border-indigo-500:focus {
            border-color: rgb(249, 115, 22) !important; /* orange-500 */
        }
        .text-indigo-600 {
            color: rgb(234, 88, 12) !important; /* orange-600 */
        }
        .hover\:text-indigo-500:hover {
            color: rgb(249, 115, 22) !important; /* orange-500 */
        }
        /* Add more overrides if needed */
    </style>
    
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <!-- Back Button -->
            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Back to Login') }}
            </a>
            
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>