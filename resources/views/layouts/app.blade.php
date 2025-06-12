<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex flex-col min-h-screen">
            <!-- Navigation -->
            <nav class="bg-white shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('products.index') }}" class="font-bold text-2xl tracking-tight">ARGABINTANG</a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="md:flex items-center space-x-8">
                            <a href="{{ route('products.index') }}" 
                            class="text-gray-600 hover:text-gray-900 font-medium border-b-2  hover:border-orange-600 {{ request()->routeIs('products.index') ? 'border-orange-600' : 'border-transparent' }}">
                                Home
                            </a>
                            <a href="{{ route('shop') }}" 
                            class="text-gray-600 hover:text-gray-900 font-medium border-b-2 hover:border-orange-600 {{ request()->routeIs('shop') ? 'border-orange-600' : 'border-transparent' }}">
                                Shop
                            </a>
                            <a href="{{ route('purchases.index') }}" 
                            class="text-gray-600 hover:text-gray-900 font-medium border-b-2 border-transparent hover:border-orange-600 focus:border-orange-600 active:border-orange-600">
                                Status Pemesanan
                            </a>
                        </div>

                        <!-- Auth Links -->
                        @guest
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('register') }}" class="bg-orange-500 text-white hover:bg-orange-600 px-6 py-2 rounded-md font-medium text-sm">
                                Daftar
                            </a>
                            <a href="{{ route('login') }}" class="border-2 border-orange-700 text-gray-700 hover:text-gray-900 hover:border-orange-900 px-4 py-2 font-medium text-sm rounded-md">
                                Masuk
                            </a>
                        </div>
                    @else
                    <div class="flex items-center space-x-6">
                        <!-- Regular Icon Links -->
                        <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-gray-900 relative">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span class="absolute -top-1 -right-2 bg-orange-500 text-white text-xs font-bold rounded-full h-4 w-4 flex items-center justify-center" style="font-size: 0.65rem;">
                            {{ Auth::check() ? Auth::user()->purchases()->where('status', 'keranjang')->count(): '0' }}
                            </span>
                        </a>
                        
                        <a href="{{ route('seller.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-store text-xl"></i>
                        </a>
                        
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.index') }}" class="text-gray-600 hover:text-gray-900">
                                <i class="fas fa-user-shield text-xl"></i>
                            </a>
                        @endif

                        <!-- User Profile Dropdown -->
                        <div class="relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div class="flex items-center">
                                           @if(Auth::user()->profile_image)
                                                <img class="h-8 w-8 rounded-full object-cover mr-2" 
                                                    src="{{ asset('storage/' . Auth::user()->profile_image) }}" 
                                                    alt="{{ Auth::user()->name }}">
                                            @else
                                                <img class="h-8 w-8 rounded-full object-cover mr-2" 
                                                    src="{{ 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                                    alt="{{ Auth::user()->name }}">
                                            @endif
                                            <div>{{ Auth::user()->name }}</div>
                                        </div>

                                        <div class="ms-1">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.index')">
                                        <i class="fas fa-user mr-2"></i> Profile
                                    </x-dropdown-link>
                                    
                                    <!-- Logout Form -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
            @endguest
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-grow py-12">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="flex flex-col space-y-8">
                        <!-- Title and Navigation -->
                        <div class="flex items-center justify-between">
                            <div class="text-xl font-bold text-gray-900">
                                ARGABINTANG
                            </div>
                            <!-- Navigation Links -->
                            <div class="flex justify-center space-x-8">
                                <a href="" class="text-gray-600 hover:text-gray-900">Home</a>
                                <a href="" class="text-gray-600 hover:text-gray-900">Community</a>
                                <a href="" class="text-gray-600 hover:text-gray-900">Marketplace</a>
                            </div>
                            <div class="flex space-x-6">
                                <a href="#" class="text-gray-600 hover:text-gray-900">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-600 hover:text-gray-900">
                                    <span class="sr-only">LinkedIn</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-600 hover:text-gray-900">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Footer Bottom -->
                        <div class="flex justify-between items-center border-t pt-8">
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-500">&copy; 2025-arga</span>
                                <a href="" class="text-sm text-gray-500 hover:text-gray-700">Terms</a>
                                <a href="" class="text-sm text-gray-500 hover:text-gray-700">Privacy</a>
                                <a href="" class="text-sm text-gray-500 hover:text-gray-700">Cookies</a>
                            </div>
                            <div class="text-sm text-gray-500">
                                UMKM Sejahtera.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>