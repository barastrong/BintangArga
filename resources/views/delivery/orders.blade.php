{{-- resources/views/delivery/orders.blade.php --}}
@extends('layouts.app')

@section('title', 'Pesanan Delivery')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Pesanan Delivery</h1>
                    <p class="text-lg text-gray-600">Kelola semua pesanan yang perlu dikirim</p>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                    <button onclick="refreshOrders()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                        <i class="fas fa-sync-alt mr-2"></i>
                        <span class="font-medium">Refresh</span>
                    </button>
                    <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                            <span class="font-medium">Real-time Updates</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            <!-- Main Content -->
            <div class="xl:col-span-3 space-y-6">
                <!-- Filter Tabs -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex flex-wrap gap-2 lg:gap-8">
                            <a href="{{ route('delivery.orders') }}" 
                               class="group py-3 px-4 border-b-2 font-medium text-sm rounded-t-lg transition-all duration-200 {{ $status == 'all' ? 'border-orange-500 text-orange-600 bg-orange-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50' }}">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-list"></i>
                                    <span>Semua</span>
                                    <span class="bg-gray-100 text-gray-900 py-1 px-3 rounded-full text-xs font-semibold">{{ $orders->total() }}</span>
                                </div>
                            </a>
                            <a href="{{ route('delivery.orders', ['status_pengiriman' => 'picked_up']) }}" 
                               class="group py-3 px-4 border-b-2 font-medium text-sm rounded-t-lg transition-all duration-200 {{ $status == 'picked_up' ? 'border-orange-500 text-orange-600 bg-orange-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50' }}">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-box-open"></i>
                                    <span>Diambil</span>
                                    <span class="bg-orange-100 text-orange-900 py-1 px-3 rounded-full text-xs font-semibold">
                                        {{ \App\Models\Purchase::where('delivery_id', Auth::user()->delivery->id)->where('status_pengiriman', 'picked_up')->count() }}
                                    </span>
                                </div>
                            </a>
                            <a href="{{ route('delivery.orders', ['status_pengiriman' => 'shipping']) }}" 
                               class="group py-3 px-4 border-b-2 font-medium text-sm rounded-t-lg transition-all duration-200 {{ $status == 'shipping' ? 'border-orange-500 text-orange-600 bg-orange-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50' }}">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-truck"></i>
                                    <span>Dalam Pengiriman</span>
                                    <span class="bg-yellow-100 text-yellow-900 py-1 px-3 rounded-full text-xs font-semibold">
                                        {{ \App\Models\Purchase::where('delivery_id', Auth::user()->delivery->id)->where('status_pengiriman', 'shipping')->count() }}
                                    </span>
                                </div>
                            </a>
                            <a href="{{ route('delivery.orders', ['status_pengiriman' => 'delivered']) }}" 
                               class="group py-3 px-4 border-b-2 font-medium text-sm rounded-t-lg transition-all duration-200 {{ $status == 'delivered' ? 'border-orange-500 text-orange-600 bg-orange-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 hover:bg-gray-50' }}">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Selesai</span>
                                    <span class="bg-green-100 text-green-900 py-1 px-3 rounded-full text-xs font-semibold">
                                        {{ \App\Models\Purchase::where('delivery_id', Auth::user()->delivery->id)->where('status_pengiriman', 'delivered')->count() }}
                                    </span>
                                </div>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Orders List -->
                @if($orders->count() > 0)
                    <div class="space-y-6">
                        @foreach($orders as $order)
                            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                                <div class="p-6">
                                    <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between">
                                        <!-- Order Info -->
                                        <div class="flex-1 mb-6 xl:mb-0">
                                            <!-- Product Header -->
                                            <div class="flex items-center space-x-4 mb-6">
                                                <div class="w-20 h-20 bg-gradient-to-r from-gray-100 to-gray-200 rounded-xl flex items-center justify-center shadow-md overflow-hidden">
                                                    @if($order->product->gambar)
                                                        <img src="{{ asset('storage/' . $order->product->gambar) }}" 
                                                             alt="{{ $order->product->nama_barang }}"
                                                             class="w-full h-full object-cover">
                                                    @else
                                                        <i class="fas fa-box text-gray-400 text-2xl"></i>
                                                    @endif
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $order->product->nama_barang }}</h3>
                                                    <p class="text-sm text-gray-600 flex items-center mb-1">
                                                        <i class="fas fa-store mr-2 text-orange-500"></i>
                                                        {{ $order->seller->nama_penjual ?? 'N/A' }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 flex items-center">
                                                        <i class="fas fa-hashtag mr-1"></i>
                                                        Order ID: {{ $order->id }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Customer & Shipping Info -->
                                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                                                <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-5 rounded-xl border border-orange-200">
                                                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                                        <i class="fas fa-user-circle mr-2 text-orange-600"></i>
                                                        Informasi Pelanggan
                                                    </h4>
                                                    <div class="space-y-2">
                                                        <p class="text-sm text-gray-700 flex items-center">
                                                            <i class="fas fa-user mr-2 text-gray-500 w-4"></i>
                                                            <span class="font-medium">{{ $order->user->name }}</span>
                                                        </p>
                                                        <p class="text-sm text-gray-700 flex items-center">
                                                            <i class="fas fa-phone mr-2 text-gray-500 w-4"></i>
                                                            <span>{{ $order->phone_number }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="bg-gradient-to-r from-green-50 to-green-100 p-5 rounded-xl border border-green-200">
                                                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                                        <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
                                                        Alamat Pengiriman
                                                    </h4>
                                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $order->shipping_address }}</p>
                                                </div>
                                            </div>

                                            <!-- Order Details -->
                                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                                    <div class="flex items-center space-x-2">
                                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                                            <i class="fas fa-cube text-purple-600 text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-500 text-xs">Quantity</p>
                                                            <p class="font-semibold text-gray-900">{{ $order->quantity }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                            <i class="fas fa-money-bill-wave text-green-600 text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-500 text-xs">Total</p>
                                                            <p class="font-semibold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                                            <i class="fas fa-clock text-orange-600 text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-500 text-xs">Tanggal</p>
                                                            <p class="font-semibold text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                                            <i class="fas fa-clock text-orange-600 text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-500 text-xs">Waktu</p>
                                                            <p class="font-semibold text-gray-900">{{ $order->created_at->format('H:i') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Status & Actions -->
                                        <div class="xl:ml-6 xl:w-64">
                                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                                <!-- Status Badge -->
                                                <div class="mb-4 text-center">
                                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold shadow-md
                                                        @if($order->status_pengiriman == 'delivered') bg-gradient-to-r from-green-500 to-green-600 text-white
                                                        @elseif($order->status_pengiriman == 'shipping') bg-gradient-to-r from-yellow-500 to-yellow-600 text-white
                                                        @elseif($order->status_pengiriman == 'picked_up') bg-gradient-to-r from-orange-500 to-orange-600 text-white
                                                        @else bg-gradient-to-r from-gray-500 to-gray-600 text-white @endif">
                                                        @if($order->status_pengiriman == 'delivered') 
                                                            <i class="fas fa-check-circle mr-2"></i>Selesai
                                                        @elseif($order->status_pengiriman == 'shipping') 
                                                            <i class="fas fa-truck mr-2"></i>Dalam Pengiriman
                                                        @elseif($order->status_pengiriman == 'picked_up') 
                                                            <i class="fas fa-box-open"></i>Diambil
                                                        @else 
                                                            <i class="fas fa-clock mr-2"></i>{{ ucfirst($order->status_pengiriman) }}
                                                        @endif
                                                    </span>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="space-y-3">
                                                    <a href="{{ route('delivery.order-detail', $order->id) }}" 
                                                    class="flex items-center justify-center w-full bg-white hover:bg-gray-50 text-gray-800 py-3 px-4 rounded-xl text-sm font-medium transition-all duration-200 border border-gray-200 hover:border-gray-300 shadow-sm">
                                                        <i class="fas fa-eye mr-2"></i>Lihat Detail
                                                    </a>

                                                    @if($order->status_pengiriman == 'picked_up')
                                                        <form action="{{ route('delivery.update-status', $order->id) }}" method="POST" class="w-full">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status_pengiriman" value="shipping">
                                                            <button type="submit" 
                                                                    onclick="return confirm('Apakah Anda yakin akan memulai pengiriman pesanan ini?')"
                                                                    class="flex items-center justify-center w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white py-3 px-4 rounded-xl text-sm font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                                <i class="fas fa-truck mr-2"></i>Mulai Kirim
                                                            </button>
                                                        </form>
                                                    @elseif($order->status_pengiriman == 'shipping')
                                                        <form action="{{ route('delivery.update-status', $order->id) }}" method="POST" class="w-full">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status_pengiriman" value="delivered">
                                                            <button type="submit" 
                                                                    onclick="return confirm('Apakah Anda yakin pesanan sudah diterima pelanggan?')"
                                                                    class="flex items-center justify-center w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 px-4 rounded-xl text-sm font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                                <i class="fas fa-check mr-2"></i>Tandai Selesai
                                                            </button>
                                                        </form>
                                                    @elseif($order->status_pengiriman != 'delivered')
                                                        <!-- Jika status bukan picked_up, shipping, atau delivered, tampilkan tombol pickup -->
                                                        <form action="{{ route('delivery.update-status', $order->id) }}" method="POST" class="w-full">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status_pengiriman" value="picked_up">
                                                            <button type="submit" 
                                                                    onclick="return confirm('Apakah Anda yakin akan mengambil pesanan ini?')"
                                                                    class="flex items-center justify-center w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3 px-4 rounded-xl text-sm font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                                <i class="fas fa-hand-holding-box mr-2"></i>Ambil Pesanan
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <!-- Quick Actions -->
                                                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-gray-200">
                                                        <button class="flex items-center justify-center bg-orange-100 hover:bg-orange-200 text-orange-700 py-2 px-3 rounded-lg text-xs font-medium transition-colors">
                                                            <i class="fas fa-phone mr-1"></i>Call
                                                        </button>
                                                        <button class="flex items-center justify-center bg-purple-100 hover:bg-purple-200 text-purple-700 py-2 px-3 rounded-lg text-xs font-medium transition-colors">
                                                            <i class="fas fa-route mr-1"></i>Route
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        {{ $orders->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-100">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-inbox text-gray-400 text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak ada pesanan</h3>
                        <p class="text-gray-500 text-lg">
                            @if($status == 'all')
                                Belum ada pesanan yang perlu dikirim
                            @else
                                Tidak ada pesanan dengan status "{{ $status }}"
                            @endif
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('delivery.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-medium transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="xl:col-span-1 space-y-6">
                @include('delivery.partials.sidebar')

                <!-- Order Statistics -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik Pesanan</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-orange-50 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-orange-500 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-700">Total Hari Ini</span>
                            </div>
                            <span class="text-lg font-bold text-orange-700">{{ $orders->total() }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-700">Selesai</span>
                            </div>
                            <span class="text-lg font-bold text-green-700">
                                {{ \App\Models\Purchase::where('delivery_id', Auth::user()->delivery->id)->where('status_pengiriman', 'delivered')->whereDate('created_at', today())->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-700">Progress</span>
                            </div>
                            <span class="text-lg font-bold text-yellow-700">75%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div id="success-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div id="error-message" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif

<script>
function refreshOrders() {
    // Add loading state
    const refreshBtn = document.querySelector('[onclick="refreshOrders()"]');
    const originalText = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span class="font-medium">Loading...</span>';
    refreshBtn.disabled = true;
    
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

// Show success/error messages
document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');
    
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.transform = 'translateX(0)';
        }, 100);
        
        setTimeout(() => {
            successMessage.style.transform = 'translateX(100%)';
        }, 5000);
    }
    
    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.transform = 'translateX(0)';
        }, 100);
        
        setTimeout(() => {
            errorMessage.style.transform = 'translateX(100%)';
        }, 5000);
    }
});

// Auto refresh every 60 seconds
setInterval(() => {
    console.log('Auto refreshing orders...');
    // Add subtle visual feedback for auto refresh
    const indicators = document.querySelectorAll('.animate-pulse');
    indicators.forEach(indicator => {
        indicator.style.animationDuration = '0.5s';
        setTimeout(() => {
            indicator.style.animationDuration = '2s';
        }, 2000);
    });
}, 60000);

// Smooth scroll animations
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    }, observerOptions);

    // Observe order cards
    document.querySelectorAll('.bg-white.rounded-2xl').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease-out';
        observer.observe(card);
    });
});

// Form confirmation and loading states
document.querySelectorAll('form[action*="update-status"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.innerHTML;
        
        // Show loading state
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
        button.disabled = true;
        
        // If user cancels confirmation, restore button
        setTimeout(() => {
            if (!this.submitted) {
                button.innerHTML = originalText;
                button.disabled = false;
            }
        }, 100);
        
        // Mark as submitted when form actually submits
        this.addEventListener('submit', () => {
            this.submitted = true;
        });
    });
});
</script>
@endsection