<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Enhanced nav links */
        .nav-link {
            transition: all 0.2s ease-in-out;
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            transform: translateX(-100%);
            transition: transform 0.2s ease-in-out;
        }
        
        .nav-link.active::before {
            transform: translateX(0);
        }
        
        .nav-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            transition: transform 0.2s ease-in-out;
        }
        
        .nav-link:hover .nav-icon {
            transform: scale(1.1);
        }
        
        /* Gradient backgrounds */
        .gradient-bg {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }
        
        /* Animated hamburger */
        .hamburger {
            transition: transform 0.2s ease-in-out;
        }
        .hamburger:hover {
            transform: scale(1.1);
        }
        
        /* Profile dropdown styles */
        .profile-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        /* Shadow effects */
        .sidebar-shadow {
            box-shadow: 4px 0 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        /* Loading animation for profile images */
        .profile-img {
            transition: all 0.3s ease;
        }
        .profile-img:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div x-data="{ sidebarOpen: false }">
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-50 flex md:hidden" x-cloak>
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm">
                <div class="absolute inset-0" @click="sidebarOpen = false"></div>
            </div>
            
            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative flex-1 flex flex-col max-w-xs w-full bg-white sidebar-shadow">
                
                <!-- Close button -->
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false" 
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full bg-white bg-opacity-20 backdrop-blur-sm text-white hover:bg-opacity-30 focus:outline-none focus:ring-2 focus:ring-white transition-all duration-200">
                        <span class="sr-only">Close sidebar</span>
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <!-- Mobile sidebar content -->
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto custom-scrollbar">
                    <!-- Logo section -->
                    <div class="flex-shrink-0 flex items-center px-6 mb-8">
                        <div class="gradient-bg p-2 rounded-lg mr-3">
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Admin Panel</h1>
                            <p class="text-xs text-gray-500">Management System</p>
                        </div>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="mt-5 px-4 space-y-2">
                        <a href="{{ route('products.index') }}" 
                           class="nav-link {{ request()->routeIs('products.index') ? 'active bg-orange-50 text-orange-900 border-orange-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl border transition-all duration-200">
                            <span class="nav-icon mr-4 {{ request()->routeIs('products.index') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-600' }}">
                                <i class="fas fa-home"></i>
                            </span>
                            <span class="font-medium">Dashboard</span>
                        </a>
                        
                        <a href="{{ route('admin.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.index') ? 'active bg-orange-50 text-orange-900 border-orange-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl border transition-all duration-200">
                            <span class="nav-icon mr-4 {{ request()->routeIs('admin.index') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-600' }}">
                                <i class="fas fa-users"></i>
                            </span>
                            <span class="font-medium">Users</span>
                        </a>
                        
                        <a href="{{ route('admin.products') }}" 
                           class="nav-link {{ request()->routeIs('admin.products') ? 'active bg-orange-50 text-orange-900 border-orange-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl border transition-all duration-200">
                            <span class="nav-icon mr-4 {{ request()->routeIs('admin.products') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-600' }}">
                                <i class="fas fa-box"></i>
                            </span>
                            <span class="font-medium">Products</span>
                        </a>
                        
                        <a href="{{ route('admin.purchases') }}" 
                           class="nav-link {{ request()->routeIs('admin.purchases') ? 'active bg-orange-50 text-orange-900 border-orange-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl border transition-all duration-200">
                            <span class="nav-icon mr-4 {{ request()->routeIs('admin.purchases') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-600' }}">
                                <i class="fas fa-shopping-cart"></i>
                            </span>
                            <span class="font-medium">Purchases</span>
                        </a>
                    </nav>
                </div>
                
                <!-- Profile section -->
                <div class="flex-shrink-0 profile-section border-t border-gray-100 p-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            @if(Auth::user()->profile_image)
                                <img class="profile-img w-10 h-10 rounded-full object-cover border-2 border-orange-200" 
                                    src="{{ asset('storage/' . Auth::user()->profile_image) }}" 
                                    alt="{{ Auth::user()->name }}">
                            @else
                                <img class="profile-img w-10 h-10 rounded-full object-cover border-2 border-orange-200" 
                                    src="{{ 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=f97316&background=fed7aa' }}" 
                                    alt="{{ Auth::user()->name }}">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name ?? 'Admin User' }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="text-gray-400 hover:text-red-500 transition-colors duration-200 p-1 rounded-md hover:bg-red-50"
                                    title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="flex-shrink-0 w-14"></div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex-1 flex flex-col min-h-0 bg-white sidebar-shadow">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto custom-scrollbar">
                    <!-- Logo section -->
                    <div class="flex items-center flex-shrink-0 px-6 mb-8">
                        <div class="gradient-bg p-2 rounded-lg mr-3">
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Admin Panel</h1>
                            <p class="text-xs text-gray-500">Management System</p>
                        </div>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="mt-5 flex-1 px-4 space-y-2">
                        <a href="{{ route('products.index') }}" 
                           class="nav-link {{ request()->routeIs('products.index') ? 'active bg-orange-50 text-orange-900 border-orange-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl border transition-all duration-200">
                            <span class="nav-icon mr-4 {{ request()->routeIs('products.index') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-600' }}">
                                <i class="fas fa-home"></i>
                            </span>
                            <span class="font-medium">Dashboard</span>
                        </a>
                        
                        <a href="{{ route('admin.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.index') ? 'active bg-orange-50 text-orange-900 border-orange-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl border transition-all duration-200">
                            <span class="nav-icon mr-4 {{ request()->routeIs('admin.index') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-600' }}">
                                <i class="fas fa-users"></i>
                            </span>
                            <span class="font-medium">Users</span>
                        </a>
                        
                        <a href="{{ route('admin.products') }}" 
                           class="nav-link {{ request()->routeIs('admin.products') ? 'active bg-orange-50 text-orange-900 border-orange-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl border transition-all duration-200">
                            <span class="nav-icon mr-4 {{ request()->routeIs('admin.products') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-600' }}">
                                <i class="fas fa-box"></i>
                            </span>
                            <span class="font-medium">Products</span>
                        </a>
                        
                        <a href="{{ route('admin.purchases') }}" 
                           class="nav-link {{ request()->routeIs('admin.purchases') ? 'active bg-orange-50 text-orange-900 border-orange-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl border transition-all duration-200">
                            <span class="nav-icon mr-4 {{ request()->routeIs('admin.purchases') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-600' }}">
                                <i class="fas fa-shopping-cart"></i>
                            </span>
                            <span class="font-medium">Purchases</span>
                        </a>
                    </nav>
                </div>
                
                <!-- Profile section -->
                <div class="flex-shrink-0 profile-section border-t border-gray-100 p-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            @if(Auth::user()->profile_image)
                                <img class="profile-img w-10 h-10 rounded-full object-cover border-2 border-orange-200" 
                                    src="{{ asset('storage/' . Auth::user()->profile_image) }}" 
                                    alt="{{ Auth::user()->name }}">
                            @else
                                <img class="profile-img w-10 h-10 rounded-full object-cover border-2 border-orange-200" 
                                    src="{{ 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=f97316&background=fed7aa' }}" 
                                    alt="{{ Auth::user()->name }}">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name ?? 'Admin User' }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="text-gray-400 hover:text-red-500 transition-colors duration-200 p-1 rounded-md hover:bg-red-50"
                                    title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main content area -->
        <div class="md:pl-64 flex flex-col flex-1 min-h-screen">
            <!-- Mobile header -->
            <div class="sticky top-0 z-10 md:hidden bg-white border-b border-gray-200 px-4 py-3">
                <div class="flex items-center justify-between">
                    <button @click="sidebarOpen = true" 
                            class="hamburger inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all duration-200">
                        <span class="sr-only">Open sidebar</span>
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    
                    <div class="flex items-center space-x-3">
                        <div class="gradient-bg p-1.5 rounded-lg">
                            <i class="fas fa-shield-alt text-white text-sm"></i>
                        </div>
                        <span class="text-lg font-bold text-gray-900">Admin</span>
                    </div>
                </div>
            </div>
            
            <!-- Main content -->
            <main class="flex-1 p-6">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>