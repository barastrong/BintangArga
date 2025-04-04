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
        /* Fix alignment issues between icon and text */
        .nav-link {
            display: flex;
            align-items: center;
        }
        .nav-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
        }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false }">
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 flex md:hidden" x-cloak>
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0">
                <div class="absolute inset-0 bg-gray-600 opacity-75" @click="sidebarOpen = false"></div>
            </div>
            
            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
                
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <i class="fas fa-times text-white"></i>
                    </button>
                </div>
                
                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <span class="text-2xl font-bold text-orange-600">Admin Panel</span>
                    </div>
                    <nav class="mt-5 px-2 space-y-1">
                        <a href="{{ route('products.index') }}" class="nav-link group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('products.index') ? 'bg-orange-100 text-orange-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span class="nav-icon mr-4 {{ request()->routeIs('products.index') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-500' }}">
                                <i class="fas fa-home"></i>
                            </span>
                            Home
                        </a>
                        <a href="{{ route('admin.index') }}" class="nav-link group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.index') ? 'bg-orange-100 text-orange-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span class="nav-icon mr-4 {{ request()->routeIs('admin.index') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-500' }}">
                                <i class="fas fa-users"></i>
                            </span>
                            Users
                        </a>
                        <a href="{{ route('admin.products') }}" class="nav-link group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.products') ? 'bg-orange-100 text-orange-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span class="nav-icon mr-4 {{ request()->routeIs('admin.products') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-500' }}">
                                <i class="fas fa-box"></i>
                            </span>
                            Products
                        </a>
                    </nav>
                </div>
                
                <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                    <div class="flex items-center">
                        <div>
                            <div class="h-9 w-9 rounded-full bg-orange-100 flex items-center justify-center">
                                <span class="text-orange-800 font-medium">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-base font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin User' }}</p>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-gray-500 hover:text-gray-700">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex-shrink-0 w-14"></div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <span class="text-2xl font-bold text-orange-600">Admin Panel</span>
                    </div>
                    <nav class="mt-5 flex-1 px-2 bg-white space-y-1">
                        <a href="{{ route('products.index') }}" class="nav-link group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('products.index') ? 'bg-orange-100 text-orange-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span class="nav-icon mr-3 flex-shrink-0 {{ request()->routeIs('products.index') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-500' }}">
                                <i class="fas fa-home"></i>
                            </span>
                            Home
                        </a>
                        <a href="{{ route('admin.index') }}" class="nav-link group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.index') ? 'bg-orange-100 text-orange-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span class="nav-icon mr-3 flex-shrink-0 {{ request()->routeIs('admin.index') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-500' }}">
                                <i class="fas fa-users"></i>
                            </span>
                            Users
                        </a>
                        <a href="{{ route('admin.products') }}" class="nav-link group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.products') ? 'bg-orange-100 text-orange-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <span class="nav-icon mr-3 flex-shrink-0 {{ request()->routeIs('admin.products') ? 'text-orange-600' : 'text-gray-400 group-hover:text-gray-500' }}">
                                <i class="fas fa-box"></i>
                            </span>
                            Products
                        </a>
                    </nav>
                </div>
                <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                    <div class="flex items-center">
                        <div>
                            <div class="h-9 w-9 rounded-full bg-orange-100 flex items-center justify-center">
                                <span class="text-orange-800 font-medium">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin User' }}</p>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-xs font-medium text-gray-500 hover:text-gray-700">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="md:pl-64 flex flex-col flex-1">
            <div class="sticky top-0 z-10 md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3 bg-white">
                <button @click="sidebarOpen = true" class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-orange-500">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <main class="flex-1">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>