@extends('layouts.app')

@section('title', 'Dashboard Delivery')

@section('content')
<div class="min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-6 lg:mb-0">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-truck text-white text-lg"></i>
                        </div>
                        <h1 class="text-4xl font-bold text-gray-900">Dashboard Delivery</h1>
                    </div>
                    <p class="text-lg text-gray-600">
                        Selamat datang kembali, 
                        <span class="font-semibold text-orange-600">{{ $delivery->nama }}</span>! 
                        <span class="text-sm text-gray-500">🚀</span>
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <div class="bg-white px-6 py-3 rounded-2xl shadow-md border border-orange-100 hover:shadow-lg transition-all duration-300 hover:border-orange-200">
                        <div class="flex items-center text-sm text-gray-700">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-alt text-orange-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold">{{ date('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ date('l') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white px-6 py-3 rounded-2xl shadow-md border border-green-100 hover:shadow-lg transition-all duration-300 hover:border-green-200">
                        <div class="flex items-center text-sm text-gray-700">
                            <div class="relative mr-3">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                <div class="absolute top-0 left-0 w-3 h-3 bg-green-400 rounded-full animate-ping"></div>
                            </div>
                            <div>
                                <p class="font-semibold text-green-700">Online</p>
                                <p class="text-xs text-gray-500">Status Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="group bg-white rounded-3xl shadow-lg p-6 border border-orange-50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 hover:scale-105 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full -mr-16 -mt-16 opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-6">
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-4 rounded-2xl shadow-xl group-hover:shadow-2xl transition-shadow duration-300">
                            <i class="fas fa-truck text-white text-2xl"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-orange-500 uppercase tracking-wider mb-1">Total Pengiriman</p>
                            <p class="text-4xl font-black text-gray-900">{{ $totalDeliveries }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm bg-orange-50 text-orange-700 px-3 py-2 rounded-xl font-medium">
                            <i class="fas fa-chart-line mr-2"></i>
                            <span>Total Keseluruhan</span>
                        </div>
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-arrow-trend-up text-orange-600 text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group bg-white rounded-3xl shadow-lg p-6 border border-green-50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 hover:scale-105 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-100 to-green-200 rounded-full -mr-16 -mt-16 opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-6">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 rounded-2xl shadow-xl group-hover:shadow-2xl transition-shadow duration-300">
                            <i class="fas fa-check-circle text-white text-2xl"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-green-500 uppercase tracking-wider mb-1">Selesai</p>
                            <p class="text-4xl font-black text-gray-900">{{ $completedDeliveries }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm bg-green-50 text-green-700 px-3 py-2 rounded-xl font-medium">
                            <i class="fas fa-percentage mr-2"></i>
                            <span>{{ $totalDeliveries > 0 ? round(($completedDeliveries / $totalDeliveries) * 100, 1) : 0 }}% Berhasil</span>
                        </div>
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-trophy text-green-600 text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group bg-white rounded-3xl shadow-lg p-6 border border-yellow-50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 hover:scale-105 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-full -mr-16 -mt-16 opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-6">
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-4 rounded-2xl shadow-xl group-hover:shadow-2xl transition-shadow duration-300">
                            <i class="fas fa-clock text-white text-2xl"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-yellow-500 uppercase tracking-wider mb-1">Sedang Dikirim</p>
                            <p class="text-4xl font-black text-gray-900">{{ $pendingDeliveries }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm bg-yellow-50 text-yellow-700 px-3 py-2 rounded-xl font-medium">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></div>
                            <span>Perlu Perhatian</span>
                        </div>
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation text-yellow-600 text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 bg-white rounded-3xl shadow-xl border border-orange-50 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6">
                    <div class="flex items-center justify-between">
                        <div class="text-white">
                            <h2 class="text-2xl font-bold mb-1">Pesanan Terbaru</h2>
                            <p class="text-orange-100 opacity-90">Daftar pesanan yang perlu diproses</p>
                        </div>
                        <a href="{{ route('delivery.orders') }}" class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white text-sm font-semibold rounded-2xl transition-all duration-300 border border-white/20 hover:border-white/40">
                            <i class="fas fa-eye mr-2"></i>
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="group flex items-center justify-between p-6 bg-gradient-to-r from-orange-25 to-orange-50 rounded-2xl hover:from-orange-50 hover:to-orange-100 transition-all duration-300 border border-orange-100 hover:border-orange-200 hover:shadow-lg">
                                    <div class="flex items-center space-x-5">
                                        <div class="relative">
                                            <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                                <i class="fas fa-box text-white text-xl"></i>
                                            </div>
                                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 text-xl mb-1">{{ $order->product->nama_barang }}</h3>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                                <div class="flex items-center">
                                                    <i class="fas fa-user mr-2 text-orange-500"></i>
                                                    <span class="font-medium">{{ $order->user->name }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-clock mr-2 text-gray-400"></i>
                                                    <span>{{ $order->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold shadow-sm
                                            @if($order->status_pengiriman == 'delivered') bg-green-100 text-green-800 border-2 border-green-200
                                            @elseif($order->status_pengiriman == 'shipping') bg-orange-100 text-orange-800 border-2 border-orange-200
                                            @elseif($order->status_pengiriman == 'picked_up') bg-blue-100 text-blue-800 border-2 border-blue-200
                                            @else bg-gray-100 text-gray-800 border-2 border-gray-200 @endif">
                                            @if($order->status_pengiriman == 'delivered') <i class="fas fa-check-circle mr-2"></i>
                                            @elseif($order->status_pengiriman == 'shipping') <i class="fas fa-truck mr-2"></i>
                                            @elseif($order->status_pengiriman == 'picked_up') <i class="fas fa-box mr-2"></i>
                                            @endif
                                            {{ ucfirst(str_replace('_', ' ', $order->status_pengiriman)) }}
                                        </span>
                                        <p class="text-2xl font-black text-gray-900 mt-3">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-20 h-20 bg-gradient-to-r from-orange-100 to-orange-200 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                                <i class="fas fa-inbox text-orange-500 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada pesanan</h3>
                            <p class="text-gray-500 text-lg">Pesanan terbaru akan muncul di sini</p>
                            <div class="mt-6">
                                <div class="inline-flex items-center px-6 py-3 bg-orange-50 text-orange-600 rounded-2xl text-sm font-medium">
                                    <i class="fas fa-bell mr-2"></i>
                                    Notifikasi akan aktif saat ada pesanan baru
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                @include('delivery.partials.sidebar')

                <div class="bg-white rounded-3xl shadow-xl p-6 border border-orange-50 overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full -mr-12 -mt-12 opacity-20"></div>
                    <div class="relative">
                        <div class="mb-6">
                            <div class="flex items-center space-x-3 mb-2">
                                <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-chart-pie text-white text-sm"></i>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">Status Hari Ini</h2>
                            </div>
                            <p class="text-sm text-gray-500 font-medium">{{ date('d F Y') }}</p>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl border border-orange-200 hover:shadow-md transition-shadow duration-300">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-orange-500 rounded-full mr-4 shadow-sm"></div>
                                    <div>
                                        <span class="text-sm font-bold text-gray-800">Pesanan Diambil</span>
                                        <p class="text-xs text-gray-600">Siap untuk dikirim</p>
                                    </div>
                                </div>
                                <span class="text-xl font-black text-orange-700 bg-orange-200 px-4 py-2 rounded-xl shadow-sm">3</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-2xl border border-yellow-200 hover:shadow-md transition-shadow duration-300">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-yellow-500 rounded-full mr-4 shadow-sm animate-pulse"></div>
                                    <div>
                                        <span class="text-sm font-bold text-gray-800">Dalam Pengiriman</span>
                                        <p class="text-xs text-gray-600">Sedang dalam perjalanan</p>
                                    </div>
                                </div>
                                <span class="text-xl font-black text-yellow-700 bg-yellow-200 px-4 py-2 rounded-xl shadow-sm">{{ $pendingDeliveries }}</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-2xl border border-green-200 hover:shadow-md transition-shadow duration-300">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-green-500 rounded-full mr-4 shadow-sm"></div>
                                    <div>
                                        <span class="text-sm font-bold text-gray-800">Berhasil Dikirim</span>
                                        <p class="text-xs text-gray-600">Sampai tujuan</p>
                                    </div>
                                </div>
                                <span class="text-xl font-black text-green-700 bg-green-200 px-4 py-2 rounded-xl shadow-sm">5</span>
                            </div>
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-orange-100">
                            <div class="flex justify-between text-sm font-semibold text-gray-700 mb-3">
                                <span>Progress Hari Ini</span>
                                <span class="text-orange-600">8/11 Pesanan</span>
                            </div>
                            <div class="relative">
                                <div class="w-full bg-orange-100 rounded-full h-3 shadow-inner">
                                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-3 rounded-full shadow-lg transition-all duration-1000 ease-out" style="width: 73%"></div>
                                </div>
                                <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-transparent via-white/20 to-transparent rounded-full"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-2">
                                <span>0%</span>
                                <span class="font-semibold text-orange-600">73%</span>
                                <span>100%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    setInterval(() => {
        console.log('Auto refresh dashboard data...');
        
        const cards = document.querySelectorAll('.group');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.transform = 'scale(0.98)';
                card.style.opacity = '0.7';
                setTimeout(() => {
                    card.style.transform = 'scale(1)';
                    card.style.opacity = '1';
                }, 300);
            }, index * 100);
        });
    }, 30000);

    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0) scale(1)';
                    }, index * 150);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.group, .transform').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px) scale(0.95)';
            card.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            observer.observe(card);
        });

        document.querySelectorAll('.group').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        const numbers = document.querySelectorAll('.text-4xl.font-black');
        numbers.forEach(number => {
            const finalNumber = parseInt(number.textContent);
            let currentNumber = 0;
            const increment = finalNumber / 30;
            
            const timer = setInterval(() => {
                currentNumber += increment;
                if (currentNumber >= finalNumber) {
                    number.textContent = finalNumber;
                    clearInterval(timer);
                } else {
                    number.textContent = Math.floor(currentNumber);
                }
            }, 50);
        });
    });

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-2xl shadow-2xl z-50 transform transition-all duration-500 translate-x-full ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'warning' ? 'bg-yellow-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
                <span class="font-medium">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(full)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 500);
        }, 5000);
    }

    @if(session('info'))
        setTimeout(() => {
            showNotification('{{ session("info") }}', 'info');
        }, 1000);
    @endif
</script>

<style>
    .from-orange-25 { --tw-gradient-from: #fffbf5; }
    .to-orange-25 { --tw-gradient-to: #fffbf5; }
    
    * {
        transition-property: transform, opacity, box-shadow, background-color, border-color;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .group:focus-within {
        transform: translateY(-4px) scale(1.01);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #f97316, #ea580c);
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #ea580c, #dc2626);
    }
</style>
@endsection