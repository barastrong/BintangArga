@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">My Profile</h1>
            <p class="text-gray-600">Manage your personal information and account settings</p>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Profile Header -->
            <div class="relative bg-gradient-to-r from-[#FF9800] to-[#FFB74D] px-8 py-12">
                <div class="flex flex-col items-center text-center">
                    <!-- Avatar -->
                        <div class="mb-4">
                            @if(Auth::user()->profile_image)
                                <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg" 
                                    src="{{ asset('storage/' . Auth::user()->profile_image) }}" 
                                    alt="{{ Auth::user()->name }}">
                            @else
                                <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg" 
                                    src="{{ 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF&size=256' }}" 
                                    alt="{{ Auth::user()->name }}">
                            @endif
                        </div>
                    
                    <!-- User Name -->
                    <h2 class="text-2xl font-bold text-white mb-2">{{ $user->name }}</h2>
                </div>
                
                <!-- Edit Button -->
                <div class="absolute top-6 right-6">
                    <a href="{{ route('profile.edit') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-lg transition-all duration-200 hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">
                            Personal Information
                        </h3>
                        
                        <!-- Full Name -->
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-[#FF9800] rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Full Name</p>
                                <p class="text-gray-800 font-medium">{{ $user->name }}</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-[#FF9800] rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email Address</p>
                                <p class="text-gray-800 font-medium">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">
                            Account Information
                        </h3>
                        
                        <!-- Email Verification -->
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-[#FF9800] rounded-lg flex items-center justify-center mr-4">
                                @if($user->email_verified_at)
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email Verification</p>
                                @if($user->email_verified_at)
                                    <p class="text-green-600 font-medium">
                                        Verified on {{ $user->email_verified_at->format('M d, Y') }}
                                    </p>
                                @else
                                    <p class="text-red-600 font-medium">Not verified</p>
                                @endif
                            </div>
                        </div>

                        <!-- Registration Date -->
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-[#FF9800] rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Member Since</p>
                                <p class="text-gray-800 font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Last Updated -->
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-[#FF9800] rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Last Updated</p>
                                <p class="text-gray-800 font-medium">{{ $user->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ route('profile.edit') }}" 
                           class="inline-flex items-center px-6 py-3 bg-[#FF9800] hover:bg-[#F57C00] text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </a>
                        

                        @if($user->role === 'user')
                        <a href="{{ route('purchases.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            My Purchases
                        </a>
                        @elseif($user->role === 'admin')
                        <a href="{{ route('admin.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Admin Panel
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats for Users -->
        @if($user->role === 'user')
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-[#FF9800] rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Purchases</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $user->purchases->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-[#FF9800] rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Cart Items</p>
                        <p class="text-2xl font-bold text-gray-800" id="cart-count">0</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Stats for Admin -->
        @if($user->role === 'admin')
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-[#FF9800] rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Users</p>
                        <p class="text-2xl font-bold text-gray-800">{{ \App\Models\User::count() ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-[#FF9800] rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Products</p>
                        <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Product::count() ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-[#FF9800] rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Purchases</p>
                        <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Purchase::count() ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Load cart count for users
@if($user->role === 'user')
document.addEventListener('DOMContentLoaded', function() {
    fetch('{{ route("cart.count") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('cart-count').textContent = data.count || 0;
        })
        .catch(error => {
            console.log('Error loading cart count:', error);
        });
});
@endif
</script>
@endsection