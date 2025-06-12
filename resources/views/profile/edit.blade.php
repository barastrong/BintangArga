@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Edit Profile</h1>
            <p class="text-gray-600">Manage your account settings and preferences</p>
        </div>

        <!-- Success/Error Messages -->
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Profile Photo Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-[#FF9800] rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Profile Photo</h2>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="text-center mb-6">
                        <!-- Current Photo -->
                        <div class="mb-4">
                            @if(Auth::user()->profile_image)
                                <img id="current-photo" class="h-32 w-32 rounded-full object-cover border-4 border-gray-200 mx-auto" 
                                     src="{{ asset('storage/' . Auth::user()->profile_image) }}" 
                                     alt="{{ Auth::user()->name }}">
                            @else
                                <img id="current-photo" class="h-32 w-32 rounded-full object-cover border-4 border-gray-200 mx-auto" 
                                     src="{{ 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF&size=256' }}" 
                                     alt="{{ Auth::user()->name }}">
                            @endif
                        </div>
                        
                        <!-- File Input -->
                        <div class="mb-4">
                            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" 
                                   class="hidden" onchange="previewImage(this)">
                            <label for="profile_photo" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg cursor-pointer transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Choose Photo
                            </label>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-[#FF9800] hover:bg-[#F57C00] text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                        Update Photo
                    </button>
                </form>
            </div>

            <!-- Username Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-[#FF9800] rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Username</h2>
                </div>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF9800] focus:border-transparent transition-all duration-200"
                               required>
                    </div>

                    <button type="submit" 
                            class="w-full bg-[#FF9800] hover:bg-[#F57C00] text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                        Update Username
                    </button>
                </form>
            </div>

            @if(!$user->google_id && !$user->github_id)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-[#FF9800] rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Change Password</h2>
                </div>

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password" 
                                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF9800] focus:border-transparent transition-all duration-200"
                                    required>
                                <button type="button" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                        onclick="togglePassword('current_password')">
                                    <svg class="h-5 w-5" id="current_password_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" 
                                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF9800] focus:border-transparent transition-all duration-200"
                                    required>
                                <button type="button" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                        onclick="togglePassword('password')">
                                    <svg class="h-5 w-5" id="password_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF9800] focus:border-transparent transition-all duration-200"
                                    required>
                                <button type="button" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                        onclick="togglePassword('password_confirmation')">
                                    <svg class="h-5 w-5" id="password_confirmation_icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full mt-6 bg-[#FF9800] hover:bg-[#F57C00] text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                        Update Password
                    </button>
                </form>
            </div>
            @endif

            <!-- Email Section (Only for regular users, not social login) -->
            @if(!$user->google_id && !$user->github_id)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-[#FF9800] rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Email Address</h2>
                </div>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FF9800] focus:border-transparent transition-all duration-200"
                               required>
                        @if($user->email_verified_at)
                            <p class="text-sm text-green-600 mt-2">✓ Email verified</p>
                        @else
                            <p class="text-sm text-red-600 mt-2">⚠ Email not verified</p>
                        @endif
                    </div>

                    <button type="submit" 
                            class="w-full bg-[#FF9800] hover:bg-[#F57C00] text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                        Update Email
                    </button>
                </form>
            </div>
            @endif
        </div>

        <!-- Delete Account Section -->
        <div class="mt-8 bg-white rounded-2xl shadow-lg border border-red-200 p-6">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-red-600">Delete Account</h2>
                    <p class="text-gray-600 text-sm">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                </div>
            </div>

            <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirmDelete()">
                @csrf
                @method('DELETE')
                
                @if(!$user->google_id && !$user->github_id)
                <div class="mb-6">
                    <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-2">Enter your password to confirm</label>
                    <input type="password" id="delete_password" name="password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200"
                           required>
                </div>
                @endif

                <button type="submit" 
                        class="bg-red-500 hover:bg-red-600 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
                    Delete Account
                </button>
            </form>
        </div>

        <!-- Back to Profile Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('profile.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Profile
            </a>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('current-photo').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function confirmDelete() {
    return confirm('Are you sure you want to delete your account? This action cannot be undone.');
}

// Auto-hide success messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successMessages = document.querySelectorAll('.bg-green-100');
    successMessages.forEach(function(message) {
        setTimeout(function() {
            message.style.display = 'none';
        }, 5000);
    });
});

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        // Change to eye-slash icon (hide password)
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
        `;
    } else {
        field.type = 'password';
        // Change to eye icon (show password)
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
    }
}
</script>
@endsection