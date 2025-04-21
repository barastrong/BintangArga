@extends('layouts.app')

@section('content')
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-3">
            <h2 class="font-bold text-3xl text-orange-600 font-serif">
                Profile Edit
            </h2>
    
            <a href="{{ route('profile.index') }}" class="inline-block px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-md transition">
                Back to profile
            </a>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
