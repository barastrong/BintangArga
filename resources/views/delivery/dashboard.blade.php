@extends('layouts.app')

@section('title', 'Dashboard Delivery')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Dashboard Delivery</h1>
                    <p class="text-lg text-gray-600">Selamat datang kembali, <span class="font-semibold text-blue-600">{{ $delivery->nama }}</span>!</p>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                    <div class="bg-white px-6 py-3 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                            <span class="font-medium">{{ date('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="bg-white px-6 py-3 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                            <span class="font-medium">Online</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Pengiriman -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-xl shadow-lg">
                        <i class="fas fa-truck text-white text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Pengiriman</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalDeliveries }}</p>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <div class="flex items-center text-green-600 bg-green-50 px-2 py-1 rounded-full">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span class="font-medium">Total keseluruhan</span>
                    </div>
                </div>
            </div>

            <!-- Pengiriman Selesai -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 rounded-xl shadow-lg">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Selesai</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $completedDeliveries }}</p>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <div class="flex items-center text-green-600 bg-green-50 px-2 py-1 rounded-full">
                        <i class="fas fa-percentage mr-1"></i>
                        <span class="font-medium">{{ $totalDeliveries > 0 ? round(($completedDeliveries / $totalDeliveries) * 100, 1) : 0 }}% dari total</span>
                    </div>
                </div>
            </div>

            <!-- Pengiriman Pending -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-4 rounded-xl shadow-lg">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Sedang Dikirim</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $pendingDeliveries }}</p>
                    </div>
                </div>
                <div class="flex items-center text-sm">
                    <div class="flex items-center text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></div>
                        <span class="font-medium">Memerlukan perhatian</span>
                    </div>
                </div>
            </div>

            <!-- Rating/Performa -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4 rounded-xl shadow-lg">
                        <i class="fas fa-star text-white text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Rating</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">4.8</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex text-yellow-400">
                        <i class="fas fa-star text-sm"></i>
                        <i class="fas fa-star text-sm"></i>
                        <i class="fas fa-star text-sm"></i>
                        <i class="fas fa-star text-sm"></i>
                        <i class="fas fa-star text-sm"></i>
                    </div>
                    <span class="text-purple-600 bg-purple-50 px-2 py-1 rounded-full font-medium">Excellent</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Pesanan Terbaru -->
            <div class="xl:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Pesanan Terbaru</h2>
                            <p class="text-sm text-gray-500 mt-1">Daftar pesanan yang perlu diproses</p>
                        </div>
                        <a href="{{ route('delivery.orders') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors duration-200">
                            <i class="fas fa-eye mr-2"></i>
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="flex items-center justify-between p-5 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-200 border border-gray-100 hover:border-gray-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-box text-white text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-lg">{{ $order->product->nama_produk }}</h3>
                                            <p class="text-sm text-gray-600 flex items-center mt-1">
                                                <i class="fas fa-user mr-1"></i>
                                                {{ $order->user->name }}
                                            </p>
                                            <p class="text-xs text-gray-400 flex items-center mt-1">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $order->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                            @if($order->status == 'delivered') bg-green-100 text-green-800 border border-green-200
                                            @elseif($order->status == 'shipping') bg-yellow-100 text-yellow-800 border border-yellow-200
                                            @elseif($order->status == 'picked_up') bg-blue-100 text-blue-800 border border-blue-200
                                            @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                                            @if($order->status == 'delivered') <i class="fas fa-check mr-1"></i>
                                            @elseif($order->status == 'shipping') <i class="fas fa-truck mr-1"></i>
                                            @elseif($order->status == 'picked_up') <i class="fas fa-box mr-1"></i>
                                            @endif
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <p class="text-lg font-bold text-gray-900 mt-2">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-gray-500 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pesanan</h3>
                            <p class="text-gray-500">Pesanan terbaru akan muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                @include('delivery.partials.sidebar')

                <!-- Status Pengiriman Hari Ini -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Status Hari Ini</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ date('d F Y') }}</p>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl border border-yellow-100">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3 shadow-sm"></div>
                                <span class="text-sm font-medium text-gray-700">Pesanan Diambil</span>
                            </div>
                            <span class="text-lg font-bold text-yellow-700 bg-yellow-100 px-3 py-1 rounded-full">3</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl border border-blue-100">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-3 shadow-sm"></div>
                                <span class="text-sm font-medium text-gray-700">Dalam Pengiriman</span>
                            </div>
                            <span class="text-lg font-bold text-blue-700 bg-blue-100 px-3 py-1 rounded-full">{{ $pendingDeliveries }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl border border-green-100">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3 shadow-sm"></div>
                                <span class="text-sm font-medium text-gray-700">Berhasil Dikirim</span>
                            </div>
                            <span class="text-lg font-bold text-green-700 bg-green-100 px-3 py-1 rounded-full">5</span>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progress Hari Ini</span>
                            <span>8/11 Pesanan</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full shadow-sm" style="width: 73%"></div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <button class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors duration-200">
                            <i class="fas fa-route mr-2"></i>
                            <span class="font-medium">Lihat Rute</span>
                        </button>
                        <button class="w-full flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl transition-colors duration-200">
                            <i class="fas fa-check-double mr-2"></i>
                            <span class="font-medium">Update Status</span>
                        </button>
                        <button class="w-full flex items-center justify-center px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-colors duration-200">
                            <i class="fas fa-history mr-2"></i>
                            <span class="font-medium">Riwayat</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto refresh setiap 30 detik untuk update real-time
    setInterval(() => {
        // Refresh data menggunakan AJAX jika diperlukan
        console.log('Auto refresh dashboard data...');
        
        // Tambahkan efek visual saat refresh
        const cards = document.querySelectorAll('.transform');
        cards.forEach(card => {
            card.style.opacity = '0.8';
            setTimeout(() => {
                card.style.opacity = '1';
            }, 500);
        });
    }, 30000);

    // Smooth scrolling untuk navigasi
    document.addEventListener('DOMContentLoaded', function() {
        // Animate cards on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.transform').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease-out';
            observer.observe(card);
        });
    });
</script>
@endsection