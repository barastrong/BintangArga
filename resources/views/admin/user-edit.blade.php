@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-none">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Edit User</h1>
                    <a href="{{ route('admin.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md transition">Back to List</a>
                </div>
                
                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Validation Error</p>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="name" name="name" id="name" value="{{ old('email', $user->name) }}" required
                            class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-none focus-visible:outline-none focus-visible:ring-5 focus-visible:ring-orange-500 focus-visible:border-orange-500">
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-none focus-visible:outline-none focus-visible:ring-5 focus-visible:ring-orange-500 focus-visible:border-orange-500">
                        </div>
                        
                        <!-- Password with toggle -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password (leave blank to keep current)</label>
                            <div class="relative">
                                <input type="password" name="password" id="password"
                                class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-none focus-visible:outline-none focus-visible:ring-5 focus-visible:ring-orange-500 focus-visible:border-orange-500">
                                <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 cursor-pointer" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Confirm Password with toggle -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 rounded-none focus-visible:outline-none focus-visible:ring-5 focus-visible:ring-orange-500 focus-visible:border-orange-500">
                                <span class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 cursor-pointer" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" id="role" class="mt-1 block w-full shadow-sm sm:text-sm border rounded-none focus:ring-orange-500 focus:border-orange-500">
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 active:bg-orange-700 focus:outline-none focus:border-orange-700 focus:ring focus:ring-orange-300 disabled:opacity-25 transition">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // For password field
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            togglePassword.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            passwordField.type = 'password';
            togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
        }
    });
    
    // For confirm password field
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordField = document.getElementById('password_confirmation');
    
    toggleConfirmPassword.addEventListener('click', function() {
        if (confirmPasswordField.type === 'password') {
            confirmPasswordField.type = 'text';
            toggleConfirmPassword.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            confirmPasswordField.type = 'password';
            toggleConfirmPassword.innerHTML = '<i class="fas fa-eye"></i>';
        }
    });
});
</script>
@endsection