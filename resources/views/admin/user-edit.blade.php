@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-2xl shadow-2xl mb-8 overflow-hidden">
            <div class="px-8 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Edit User</h1>
                        <p class="text-orange-100">Update user information and permissions</p>
                    </div>
                    <a href="{{ url()->previous() }}" 
                       class="group bg-white/20 backdrop-blur-sm hover:bg-white/30 px-6 py-3 rounded-xl text-white font-semibold transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Back to List</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden border border-orange-100">
            <div class="p-8">
                @if($errors->any())
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-400 rounded-lg p-6 mb-8 shadow-lg" role="alert">
                        <div class="flex items-start">
                            <div class="bg-red-100 rounded-full p-2 mr-4">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-red-800 mb-2">Validation Errors</p>
                                <ul class="text-red-700 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li class="flex items-center">
                                            <span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Name Field -->
                        <div class="group">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-3 group-focus-within:text-orange-600 transition-colors duration-200">
                                Full Name
                            </label>
                            <div class="relative">
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full px-4 py-4 bg-gradient-to-r from-white to-orange-50 border-2 border-orange-200 rounded-xl text-gray-800 placeholder-gray-400 
                                              focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20 focus:bg-white
                                              transition-all duration-300 transform focus:scale-[1.02]">
                                <div class="absolute inset-0 bg-gradient-to-r from-orange-500/0 to-amber-500/0 rounded-xl opacity-0 group-focus-within:opacity-10 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                        </div>
                        
                        <!-- Email Field -->
                        <div class="group">
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-3 group-focus-within:text-orange-600 transition-colors duration-200">
                                Email Address
                            </label>
                            <div class="relative">
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full px-4 py-4 bg-gradient-to-r from-white to-orange-50 border-2 border-orange-200 rounded-xl text-gray-800 placeholder-gray-400 
                                              focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20 focus:bg-white
                                              transition-all duration-300 transform focus:scale-[1.02]">
                                <div class="absolute inset-0 bg-gradient-to-r from-orange-500/0 to-amber-500/0 rounded-xl opacity-0 group-focus-within:opacity-10 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                        </div>
                        
                        <!-- Password Field -->
                        <div class="group">
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-3 group-focus-within:text-orange-600 transition-colors duration-200">
                                New Password
                                <span class="text-xs font-normal text-gray-500 ml-2">(leave blank to keep current)</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password"
                                       class="w-full px-4 py-4 pr-12 bg-gradient-to-r from-white to-orange-50 border-2 border-orange-200 rounded-xl text-gray-800 placeholder-gray-400 
                                              focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20 focus:bg-white
                                              transition-all duration-300 transform focus:scale-[1.02]">
                                <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-orange-600 transition-colors duration-200 p-1" id="togglePassword">
                                    <svg class="w-5 h-5" id="eyeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <div class="absolute inset-0 bg-gradient-to-r from-orange-500/0 to-amber-500/0 rounded-xl opacity-0 group-focus-within:opacity-10 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                        </div>
                        
                        <!-- Confirm Password Field -->
                        <div class="group">
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-3 group-focus-within:text-orange-600 transition-colors duration-200">
                                Confirm Password
                            </label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full px-4 py-4 pr-12 bg-gradient-to-r from-white to-orange-50 border-2 border-orange-200 rounded-xl text-gray-800 placeholder-gray-400 
                                              focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20 focus:bg-white
                                              transition-all duration-300 transform focus:scale-[1.02]">
                                <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-orange-600 transition-colors duration-200 p-1" id="toggleConfirmPassword">
                                    <svg class="w-5 h-5" id="eyeConfirmIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <div class="absolute inset-0 bg-gradient-to-r from-orange-500/0 to-amber-500/0 rounded-xl opacity-0 group-focus-within:opacity-10 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                        </div>

                        <!-- Role Field -->
                        <div class="group lg:col-span-2">
                            <label for="role" class="block text-sm font-bold text-gray-700 mb-3 group-focus-within:text-orange-600 transition-colors duration-200">
                                User Role
                            </label>
                            <div class="relative">
                                <select name="role" id="role" 
                                        class="w-full px-4 py-4 bg-gradient-to-r from-white to-orange-50 border-2 border-orange-200 rounded-xl text-gray-800 
                                               focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20 focus:bg-white
                                               transition-all duration-300 transform focus:scale-[1.02] cursor-pointer">
                                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }} 
                                            class="bg-white text-gray-800 py-2">👤 Regular User</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }} 
                                            class="bg-white text-gray-800 py-2">👑 Administrator</option>
                                </select>
                                <div class="absolute inset-0 bg-gradient-to-r from-orange-500/0 to-amber-500/0 rounded-xl opacity-0 group-focus-within:opacity-10 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex justify-end pt-8 border-t border-orange-100">
                        <button type="submit" 
                                class="group relative bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 
                                       text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl 
                                       transform hover:scale-105 transition-all duration-300 
                                       focus:outline-none focus:ring-4 focus:ring-orange-500/50">
                            <span class="relative z-10 flex items-center space-x-2">
                                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Update User</span>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 to-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced password toggle functionality
    function createPasswordToggle(toggleId, fieldId, iconId) {
        const toggle = document.getElementById(toggleId);
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(iconId);
        
        if (!toggle || !field || !icon) return;
        
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
                toggle.classList.add('text-orange-600');
            } else {
                field.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
                toggle.classList.remove('text-orange-600');
            }
            
            // Add a subtle animation effect
            toggle.classList.add('animate-pulse');
            setTimeout(() => toggle.classList.remove('animate-pulse'), 200);
        });
    }
    
    // Initialize password toggles
    createPasswordToggle('togglePassword', 'password', 'eyeIcon');
    createPasswordToggle('toggleConfirmPassword', 'password_confirmation', 'eyeConfirmIcon');
    
    // Add form validation feedback
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, select');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() !== '') {
                this.classList.add('border-green-300', 'bg-green-50');
                this.classList.remove('border-orange-200');
            } else if (this.hasAttribute('required')) {
                this.classList.add('border-red-300', 'bg-red-50');
                this.classList.remove('border-orange-200', 'border-green-300');
            }
        });
        
        input.addEventListener('focus', function() {
            this.classList.remove('border-green-300', 'bg-green-50', 'border-red-300', 'bg-red-50');
            this.classList.add('border-orange-500');
        });
    });
});
</script>

<style>
@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient-shift 3s ease infinite;
}

/* Custom scrollbar for better aesthetics */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #fef7ed;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #f97316, #f59e0b);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #ea580c, #d97706);
}
</style>
@endsection