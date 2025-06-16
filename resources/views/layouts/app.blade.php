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
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="flex flex-col min-h-screen">
            <!-- Navigation -->
            <nav x-data="{ open: false }" class="bg-white shadow-sm sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('products.index') }}" class="font-extrabold text-2xl tracking-tight text-gray-800">ARGABINTANG</a>
                        </div>

                        <!-- Desktop Navigation Links -->
                        <div class="hidden md:flex items-center space-x-8">
                            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 font-medium border-b-2 py-2 {{ request()->routeIs('products.index') ? 'border-orange-500 text-gray-900' : 'border-transparent' }}">
                                Home
                            </a>
                            <a href="{{ route('shop') }}" class="text-gray-600 hover:text-gray-900 font-medium border-b-2 py-2 {{ request()->routeIs('shop') ? 'border-orange-500 text-gray-900' : 'border-transparent' }}">
                                Shop
                            </a>
                            <a href="{{ route('purchases.index') }}" class="text-gray-600 hover:text-gray-900 font-medium border-b-2 py-2 {{ request()->routeIs('purchases.index') ? 'border-orange-500 text-gray-900' : 'border-transparent' }}">
                                Status Pemesanan
                            </a>
                        </div>

                        <!-- Desktop Auth Links -->
                        <div class="hidden md:flex items-center space-x-4">
                            @guest
                                <a href="{{ route('register') }}" class="bg-orange-500 text-white hover:bg-orange-600 px-5 py-2 rounded-md font-medium text-sm transition-colors">
                                    Daftar
                                </a>
                                <a href="{{ route('login') }}" class="border border-gray-300 text-gray-700 hover:bg-gray-100 px-5 py-2 font-medium text-sm rounded-md transition-colors">
                                    Masuk
                                </a>
                            @else
                                <div class="flex items-center space-x-6">
                                    <!-- Icons -->
                                    <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-gray-900 relative">
                                        <i class="fas fa-shopping-cart text-xl"></i>
                                        <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                            {{ Auth::check() ? Auth::user()->purchases()->where('status', 'keranjang')->count(): '0' }}
                                        </span>
                                    </a>
                                    <a href="{{ route('seller.dashboard') }}" class="text-gray-600 hover:text-gray-900"> <i class="fas fa-store text-xl"></i> </a>

                                    @if(Auth::user()->role === 'user' || Auth::user()->role === 'admin')
                                        <a href="{{ route('delivery.dashboard') }}" class="text-gray-600 hover:text-gray-900" title="Delivery Dashboard">
                                            <i class="fas fa-truck text-xl"></i>
                                        </a>
                                    @endif

                                    @if (Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.index') }}" class="text-gray-600 hover:text-gray-900"><i class="fas fa-user-shield text-xl"></i></a>
                                    @endif

                                    <!-- User Profile Dropdown -->
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition">
                                                @if(Auth::user()->profile_image)
                                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}">
                                                @else
                                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=FFFFFF&background=F97316' }}" alt="{{ Auth::user()->name }}">
                                                @endif
                                                <div class="ml-2 hidden lg:block">{{ Auth::user()->name }}</div>
                                                <div class="ms-1"><i class="fas fa-chevron-down text-xs"></i></div>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('profile.index')"><i class="fas fa-user mr-2 w-4"></i> Profile</x-dropdown-link>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    <i class="fas fa-sign-out-alt mr-2 w-4"></i> {{ __('Log Out') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            @endguest
                        </div>
                        
                        <!-- Burger Menu Button -->
                        <div class="md:hidden flex items-center">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="{{ route('products.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('products.index') ? 'border-orange-500 bg-orange-50 text-orange-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Home</a>
                        <a href="{{ route('shop') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('shop') ? 'border-orange-500 bg-orange-50 text-orange-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Shop</a>
                        <a href="{{ route('purchases.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('purchases.index') ? 'border-orange-500 bg-orange-50 text-orange-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Status Pemesanan</a>
                    </div>
                    
                    <!-- Mobile Auth Links -->
                    <div class="pt-4 pb-3 border-t border-gray-200">
                        @guest
                            <div class="px-4 space-y-2">
                                <a href="{{ route('register') }}" class="block text-center bg-orange-500 text-white hover:bg-orange-600 px-5 py-2 rounded-md font-medium text-sm transition-colors">Daftar</a>
                                <a href="{{ route('login') }}" class="block text-center border border-gray-300 text-gray-700 hover:bg-gray-100 px-5 py-2 font-medium text-sm rounded-md transition-colors">Masuk</a>
                            </div>
                        @else
                            <div class="flex items-center px-4">
                                <div class="flex-shrink-0">
                                    @if(Auth::user()->profile_image)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="">
                                    @else
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=FFFFFF&background=F97316' }}" alt="">
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1">
                                <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Profile</a>
                                <!-- Tambahkan link mobile lainnya di sini jika perlu -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                        Log Out
                                    </a>
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-grow">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="text-center text-gray-500 text-sm">
                        © {{ date('Y') }} ARGABINTANG. All Rights Reserved.
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>