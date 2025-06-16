@extends('layouts.admin')

@section('title', 'User Detail')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">User Details</h1>
                    <p class="mt-1 text-sm text-gray-600">Manage user information and settings</p>
                </div>
                <a href="{{ url()->previous() }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-8">
                <div class="flex items-center space-x-6">
                    <div class="relative">
                        <div class="h-20 w-20 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center ring-4 ring-white/30">
                            <span class="text-white text-3xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div class="absolute -bottom-2 -right-2 h-6 w-6 bg-green-400 rounded-full border-3 border-white"></div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                        <p class="text-orange-100 text-sm">ID: {{ $user->id }}</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                       {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Personal Information
                            </h3>
                            <div class="space-y-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dt class="text-sm font-medium text-gray-600">Full Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $user->name }}</dd>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dt class="text-sm font-medium text-gray-600">Email Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $user->email }}</dd>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dt class="text-sm font-medium text-gray-600">Email Verification</dt>
                                    <dd class="mt-1 flex items-center">
                                        @if($user->email_verified_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                Verified
                                            </span>
                                            <span class="ml-2 text-xs text-gray-500">{{ $user->email_verified_at->format('M d, Y H:i') }}</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                                Not Verified
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Account Information
                            </h3>
                            <div class="space-y-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dt class="text-sm font-medium text-gray-600">Account Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $user->created_at->format('M d, Y') }}</dd>
                                    <dd class="text-xs text-gray-500">{{ $user->created_at->format('H:i:s') }}</dd>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dt class="text-sm font-medium text-gray-600">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $user->updated_at->format('M d, Y') }}</dd>
                                    <dd class="text-xs text-gray-500">{{ $user->updated_at->format('H:i:s') }}</dd>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <dt class="text-sm font-medium text-gray-600">Account Status</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                                            Active
                                        </span>
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit User
                    </a>
                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');"
                          class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection