@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    /* Custom Scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Enhanced hover effects */
    .hover-lift:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
<body>
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                @include('sellers.partials.sidebar')
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-6">
                
                <!-- Header Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Manajemen Pesanan</h1>
                            <p class="text-gray-600">Kelola semua pesanan yang masuk dari pelanggan</p>
                        </div>
                        
                        <!-- Filter dan Search (untuk pengembangan selanjutnya) -->
                        <div class="flex space-x-3 mt-4 sm:mt-0">
                            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fas fa-filter mr-2"></i>
                                Filter
                            </button>
                            <button class="inline-flex items-center px-4 py-2 bg-orange-500 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                                <i class="fas fa-download mr-2"></i>
                                Export
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-orange-100 rounded-lg">
                                <i class="fas fa-shopping-cart text-orange-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $orders->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-amber-100 rounded-lg">
                                <i class="fas fa-clock text-amber-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Menunggu</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $orders->where('status', 'pending')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Selesai</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $orders->whereIn('status', ['completed', 'selesai'])->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-orange-200 rounded-lg">
                                <i class="fas fa-truck text-orange-700"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Dikirim</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $orders->where('status', 'dikirim')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900">Daftar Pesanan</h2>
                            <div class="flex items-center space-x-2 text-sm text-gray-500">
                                <i class="fas fa-info-circle"></i>
                                <span>{{ $orders->count() }} total pesanan</span>
                            </div>
                        </div>
                    </div>
                    
                    @if($orders->isEmpty())
                        <div class="text-center py-20 px-6">
                            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                                <i class="fas fa-receipt text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pesanan</h3>
                            <p class="text-gray-500 max-w-sm mx-auto">Pesanan dari pelanggan akan muncul di sini setelah mereka melakukan pembelian.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50/80">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order ID</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pelanggan</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Produk</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Detail</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pembayaran</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status Bayar</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status Order</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-hashtag text-orange-600 text-xs"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-semibold text-gray-900">{{ $order->id }}</div>
                                                    <div class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-600 text-xs"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'N/A' }}</div>
                                                    <div class="text-xs text-gray-500">{{ $order->user->email ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $order->product->nama_barang ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($order->product->deskripsi ?? '', 30) }}</div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <div class="flex items-center mb-1">
                                                    <i class="fas fa-expand-arrows-alt text-gray-400 text-xs mr-1"></i>
                                                    <span class="font-medium">{{ $order->size->size ?? 'N/A' }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-cubes text-gray-400 text-xs mr-1"></i>
                                                    <span>{{ $order->quantity }} pcs</span>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                            <div class="text-xs text-gray-500">@rp{{ number_format($order->total_price / $order->quantity, 0, ',', '.') }}/pcs</div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($order->payment_method == 'gopay')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-mobile-alt mr-1"></i>
                                                    GoPay
                                                </span>
                                            @elseif($order->payment_method == 'qris')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-qrcode mr-1"></i>
                                                    QRIS
                                                </span>
                                            @elseif($order->payment_method == 'dana')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-wallet mr-1"></i>
                                                    DANA
                                                </span>
                                            @elseif($order->payment_method == 'bank_transfer')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    <i class="fas fa-university mr-1"></i>
                                                    Transfer Bank
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($order->payment_status == 'paid')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Lunas
                                                </span>
                                            @elseif($order->payment_status == 'unpaid')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Belum Bayar
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($order->status == 'completed' || $order->status == 'selesai')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-double mr-1"></i>
                                                    Selesai
                                                </span>
                                            @elseif($order->status == 'process' || $order->status == 'diproses')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-cogs mr-1"></i>
                                                    Diproses
                                                </span>
                                            @elseif($order->status == 'pending')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-hourglass-half mr-1"></i>
                                                    Menunggu
                                                </span>
                                            @elseif($order->status == 'dikirim')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    <i class="fas fa-shipping-fast mr-1"></i>
                                                    Dikirim
                                                </span>
                                            @elseif($order->status == 'cancelled')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Dibatalkan
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-ban mr-1"></i>
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div>{{ $order->created_at->format('d M Y') }}</div>
                                            <div class="text-xs">{{ $order->created_at->format('H:i') }}</div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($order->status != 'dikirim' && $order->status != 'selesai' && $order->status != 'cancelled')
                                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                                    <div>
                                                        <button @click="open = !open" type="button" class="inline-flex items-center justify-center w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all duration-200">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                    </div>
                                                    <div x-show="open" @click.away="open = false" 
                                                         x-transition:enter="transition ease-out duration-100"
                                                         x-transition:enter-start="transform opacity-0 scale-95"
                                                         x-transition:enter-end="transform opacity-100 scale-100"
                                                         x-transition:leave="transition ease-in duration-75"
                                                         x-transition:leave-start="transform opacity-100 scale-100"
                                                         x-transition:leave-end="transform opacity-0 scale-95"
                                                         class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20 border border-gray-100">
                                                        <div class="py-2" role="menu" aria-orientation="vertical">
                                                            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase border-b border-gray-100">
                                                                Ubah Status
                                                            </div>
                                                            @if($order->status == 'pending')
                                                                <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST" class="block">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="status" value="process">
                                                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 flex items-center transition-colors duration-150" role="menuitem">
                                                                        <i class="fas fa-play-circle mr-3 text-orange-500"></i>
                                                                        Mulai Proses
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            
                                                            @if(in_array($order->status, ['pending', 'process', 'diproses']))
                                                                <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST" class="block">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="status" value="dikirim">
                                                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 flex items-center transition-colors duration-150" role="menuitem">
                                                                        <i class="fas fa-truck mr-3 text-orange-600"></i>
                                                                        Tandai Dikirim
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            
                                                            <div class="border-t border-gray-100 mt-2 pt-2">
                                                                <button class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center transition-colors duration-150" role="menuitem">
                                                                    <i class="fas fa-eye mr-3 text-gray-400"></i>
                                                                    Lihat Detail
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($order->status == 'cancelled')
                                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100">
                                                    <i class="fas fa-times text-red-500 text-xs"></i>
                                                </div>
                                            @else
                                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100">
                                                    <i class="fas fa-check text-green-400 text-xs"></i>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination (jika diperlukan) -->
                        @if(method_exists($orders, 'links'))
                            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                                {{ $orders->links() }}
                            </div>
                        @endif
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay untuk Form Submit -->
<div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-orange-600"></div>
        <span class="text-gray-700">Memproses...</span>
    </div>
</div>
<script>
    // Show loading overlay saat form disubmit
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form[action*="update-status"]');
        const loadingOverlay = document.getElementById('loadingOverlay');
        
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                loadingOverlay.classList.remove('hidden');
            });
        });
    });
    
    // Auto refresh halaman setiap 5 menit untuk update status terbaru
    setTimeout(function() {
        location.reload();
    }, 300000); // 5 menit
</script>
</body>
</html>
@endsection