@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Mobile Sidebar Toggle -->
        <div class="lg:hidden mb-4">
            <button id="sidebar-toggle" class="bg-white p-3 rounded-lg shadow-md border border-gray-200">
                <i class="fas fa-bars text-gray-600"></i>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Main Content -->
            <div class="flex-1 order-1 lg:order-1">
                <!-- Header Section with Breadcrumb -->
                <div class="bg-white rounded-3xl shadow-lg border border-orange-100 p-8 mb-8 backdrop-blur-sm bg-white/90">
                    <!-- Breadcrumb -->
                    <nav class="flex text-sm text-gray-500 mb-6">
                        <a href="{{ route('delivery.dashboard') }}" class="hover:text-orange-600 transition-colors duration-300 font-medium">Dashboard</a>
                        <span class="mx-3 text-orange-300">/</span>
                        <span class="text-orange-600 font-semibold">Profil</span>
                    </nav>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent mb-3">Profil Delivery</h1>
                            <p class="text-gray-600 text-lg">Kelola informasi profil dan lihat statistik pengiriman Anda</p>
                        </div>
                        <a href="{{ route('delivery.edit-profile') }}" 
                           class="group inline-flex items-center justify-center bg-gradient-to-r from-orange-500 via-orange-600 to-orange-500 hover:from-orange-600 hover:via-orange-700 hover:to-orange-600 text-white px-8 py-4 rounded-2xl transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 font-semibold text-lg">
                            <div class="w-5 h-5 mr-3 transition-transform group-hover:rotate-12">
                                <i class="fas fa-edit"></i>
                            </div>
                            Edit Profil
                        </a>
                    </div>
                </div>

                <!-- Profile Card -->
                <div class="bg-white rounded-3xl shadow-xl border border-orange-100 overflow-hidden mb-8 backdrop-blur-sm bg-white/95">
                    <!-- Enhanced Cover Photo with Pattern -->
                    <div class="relative h-48 bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-400/20 via-transparent to-orange-600/20"></div>
                        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.2) 1px, transparent 1px); background-size: 20px 20px;"></div>
                        <div class="absolute top-4 right-4">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-3">
                                <i class="fas fa-truck text-white text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="relative px-8 pb-10 pt-6">
                        <!-- Profile Picture and Basic Info -->
                        <div class="flex flex-col sm:flex-row sm:items-end -mt-24 mb-10">
                            <div class="relative mb-6 sm:mb-0">
                                @if($delivery->foto_profile)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $delivery->foto_profile) }}" 
                                             alt="Profil Delivery" 
                                             class="w-36 h-36 rounded-3xl object-cover border-4 border-white shadow-2xl ring-4 ring-orange-100">
                                        <div class="absolute inset-0 w-36 h-36 rounded-3xl bg-gradient-to-tr from-orange-500/20 to-transparent"></div>
                                    </div>
                                @else
                                    <div class="w-36 h-36 rounded-3xl bg-gradient-to-br from-orange-100 via-orange-200 to-orange-300 border-4 border-white shadow-2xl flex items-center justify-center ring-4 ring-orange-100">
                                        <span class="text-5xl font-bold text-orange-600">
                                            {{ substr($delivery->nama, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                                <!-- Enhanced Online Status Indicator -->
                                <div class="absolute -bottom-3 -right-3 w-8 h-8 bg-gradient-to-r from-green-400 to-green-500 border-4 border-white rounded-2xl shadow-lg flex items-center justify-center">
                                    <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                </div>
                            </div>
                            
                            <div class="sm:ml-8 flex-1">
                                <h2 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-2">{{ $delivery->nama }}</h2>
                                <p class="text-gray-600 mb-4 flex items-center text-lg">
                                    <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-truck text-white text-sm"></i>
                                    </div>
                                    Delivery Partner Professional
                                </p>
                                <div class="flex flex-wrap gap-3">
                                    <span class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 text-sm font-semibold rounded-2xl border border-orange-200 shadow-sm">
                                        <i class="fas fa-id-card mr-2 text-orange-600"></i>
                                        ID: {{ $delivery->delivery_serial }}
                                    </span>
                                    <span class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-100 to-emerald-200 text-green-800 text-sm font-semibold rounded-2xl border border-green-200 shadow-sm">
                                        <i class="fas fa-check-circle mr-2 text-green-600"></i>
                                        Verified Partner
                                    </span>
                                    <span class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-100 to-indigo-200 text-blue-800 text-sm font-semibold rounded-2xl border border-blue-200 shadow-sm">
                                        <i class="fas fa-star mr-2 text-blue-600"></i>
                                        Premium Member
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Details Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Personal Information -->
                            <div class="bg-gradient-to-br from-orange-50 via-orange-50 to-orange-100 rounded-3xl p-8 border border-orange-200 shadow-lg">
                                <div class="flex items-center mb-8">
                                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                                        <i class="fas fa-user text-white text-lg"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900">Informasi Personal</h3>
                                </div>
                                
                                <div class="space-y-6">
                                    <div class="flex items-start space-x-4 bg-white/70 rounded-2xl p-4 border border-orange-100">
                                        <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-user-circle text-white text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-sm font-bold text-orange-700 mb-2">Nama Lengkap</label>
                                            <p class="text-gray-900 font-semibold text-lg">{{ $delivery->nama }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start space-x-4 bg-white/70 rounded-2xl p-4 border border-orange-100">
                                        <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-envelope text-white text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-sm font-bold text-orange-700 mb-2">Email</label>
                                            <p class="text-gray-900 font-semibold break-all">{{ $delivery->email }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start space-x-4 bg-white/70 rounded-2xl p-4 border border-orange-100">
                                        <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-phone text-white text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-sm font-bold text-orange-700 mb-2">No. Telepon</label>
                                            <p class="text-gray-900 font-semibold">{{ $delivery->no_telepon }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start space-x-4 bg-white/70 rounded-2xl p-4 border border-orange-100">
                                        <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-calendar-alt text-white text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-sm font-bold text-orange-700 mb-2">Tanggal Bergabung</label>
                                            <p class="text-gray-900 font-semibold">{{ $delivery->created_at->format('d F Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics -->
                            <div class="bg-gradient-to-br from-orange-50 via-orange-50 to-red-50 rounded-3xl p-8 border border-orange-200 shadow-lg">
                                <div class="flex items-center mb-8">
                                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                                        <i class="fas fa-chart-bar text-white text-lg"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900">Statistik Pengiriman</h3>
                                </div>
                                
                                @php
                                    $totalDeliveries = App\Models\Purchase::where('delivery_id', $delivery->id)->count();
                                    $completedDeliveries = App\Models\Purchase::where('delivery_id', $delivery->id)
                                        ->where('status_pengiriman', 'delivered')->count();
                                    $pendingDeliveries = App\Models\Purchase::where('delivery_id', $delivery->id)
                                        ->whereIn('status_pengiriman', ['pending', 'picked_up', 'shipping'])->count();
                                    $successRate = $totalDeliveries > 0 ? round(($completedDeliveries / $totalDeliveries) * 100, 1) : 0;
                                @endphp
                                
                                <div class="grid grid-cols-2 gap-4 mb-8">
                                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 text-center shadow-lg border border-orange-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                        <div class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent mb-2">{{ $totalDeliveries }}</div>
                                        <div class="text-sm text-gray-700 font-semibold">Total Pengiriman</div>
                                    </div>
                                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 text-center shadow-lg border border-green-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                        <div class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-500 bg-clip-text text-transparent mb-2">{{ $completedDeliveries }}</div>
                                        <div class="text-sm text-gray-700 font-semibold">Selesai</div>
                                    </div>
                                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 text-center shadow-lg border border-yellow-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                        <div class="text-4xl font-bold bg-gradient-to-r from-yellow-600 to-orange-500 bg-clip-text text-transparent mb-2">{{ $pendingDeliveries }}</div>
                                        <div class="text-sm text-gray-700 font-semibold">Dalam Proses</div>
                                    </div>
                                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 text-center shadow-lg border border-blue-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                        <div class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-500 bg-clip-text text-transparent mb-2">{{ $successRate }}%</div>
                                        <div class="text-sm text-gray-700 font-semibold">Success Rate</div>
                                    </div>
                                </div>

                                <!-- Enhanced Progress Bar -->
                                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-orange-100 shadow-lg">
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-sm font-bold text-gray-700">Progress Pengiriman</span>
                                        <span class="text-lg font-bold bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent">{{ $successRate }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden shadow-inner">
                                        <div class="bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 h-4 rounded-full transition-all duration-1000 ease-out shadow-lg relative" 
                                             style="width: {{ $successRate }}%">
                                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-pulse"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-3xl shadow-xl border border-orange-100 p-8 backdrop-blur-sm bg-white/95">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-clock text-white text-lg"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Aktivitas Terakhir</h3>
                        </div>
                        <a href="{{ route('delivery.orders') }}" class="group text-sm text-orange-600 hover:text-orange-700 font-semibold flex items-center bg-orange-50 hover:bg-orange-100 px-4 py-2 rounded-xl transition-all duration-300">
                            Lihat Semua
                            <div class="ml-2 transform group-hover:translate-x-1 transition-transform">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                    
                    @php
                        $recentOrders = App\Models\Purchase::with(['product', 'user'])
                            ->where('delivery_id', $delivery->id)
                            ->orderBy('updated_at', 'desc')
                            ->take(5)
                            ->get();
                    @endphp

                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="group flex items-center justify-between bg-gradient-to-r from-orange-50/50 via-white to-orange-50/50 rounded-2xl p-6 border border-orange-100 hover:shadow-lg hover:border-orange-200 transition-all duration-300 hover:-translate-y-1">
                                    <div class="flex items-center space-x-5">
                                        <div class="w-14 h-14 bg-gradient-to-br from-orange-100 to-orange-200 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-md group-hover:shadow-lg transition-shadow">
                                            <i class="fas fa-box text-orange-600 text-lg"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-base font-bold text-gray-900 truncate mb-1">
                                                {{ Str::limit($order->product->nama_barang, 35) }}
                                            </p>
                                            <p class="text-sm text-gray-600 flex items-center">
                                                <i class="fas fa-clock mr-2 text-orange-500"></i>
                                                {{ $order->updated_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    @php
                                        $statusConfig = [
                                            'pending' => ['class' => 'bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 border-yellow-200', 'text' => 'Pending', 'icon' => 'fas fa-clock'],
                                            'picked_up' => ['class' => 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border-blue-200', 'text' => 'Picked Up', 'icon' => 'fas fa-hand-paper'],
                                            'shipping' => ['class' => 'bg-gradient-to-r from-orange-100 to-red-100 text-orange-800 border-orange-200', 'text' => 'Shipping', 'icon' => 'fas fa-truck'],
                                            'delivered' => ['class' => 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-green-200', 'text' => 'Delivered', 'icon' => 'fas fa-check-circle']
                                        ];
                                        $currentStatus = $statusConfig[$order->status_pengiriman] ?? ['class' => 'bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 border-gray-200', 'text' => 'Unknown', 'icon' => 'fas fa-question'];
                                    @endphp
                                    <span class="inline-flex items-center px-4 py-2.5 text-sm font-bold rounded-xl border shadow-sm {{ $currentStatus['class'] }}">
                                        <i class="{{ $currentStatus['icon'] }} mr-2"></i>
                                        {{ $currentStatus['text'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-20 h-20 bg-gradient-to-br from-orange-100 to-orange-200 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                                <i class="fas fa-history text-orange-400 text-3xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Belum Ada Aktivitas</h4>
                            <p class="text-gray-500 text-lg">Aktivitas pengiriman Anda akan muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar (Mobile: Hidden by default, Desktop: Always visible) -->
            <div id="sidebar" class="w-full lg:w-64 flex-shrink-0 order-2 lg:order-2 hidden lg:block">
                @include('delivery.partials.sidebar')
            </div>
        </div>
    </div>
</div>

<!-- Mobile Sidebar Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    if (sidebarToggle && sidebar && sidebarOverlay) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('hidden');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.add('hidden');
            sidebarOverlay.classList.add('hidden');
        });
    }
});
</script>

@endsection