@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
<div class="py-8 px-4">
    <div class="max-w-5xl mx-auto">

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('purchases.index') }}" class="inline-flex items-center gap-3 text-gray-600 hover:text-orange-600 transition-all duration-200 group">
                <div class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center group-hover:shadow-lg transition-shadow">
                    <i class="fas fa-arrow-left text-sm"></i>
                </div>
                <span class="font-medium">Kembali ke Riwayat Pesanan</span>
            </a>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 mb-6 rounded-lg shadow-sm animate-pulse" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 text-red-800 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Main Order Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Header with Status -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 text-white">
                <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">Pesanan #{{ $purchase->id }}</h1>
                        <p class="text-orange-100 flex items-center gap-2">
                            <i class="fas fa-calendar-alt"></i>
                            Dipesan pada {{ $purchase->created_at->format('d F Y, H:i') }}
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        @php
                            $statusInfo = [
                                'pending' => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-yellow-100 text-yellow-800 border-yellow-200'],
                                'diproses' => ['label' => 'Diproses', 'class' => 'bg-blue-100 text-blue-800 border-blue-200'],
                                'process' => ['label' => 'Diproses', 'class' => 'bg-blue-100 text-blue-800 border-blue-200'],
                                'dikirim' => ['label' => 'Dikirim', 'class' => 'bg-purple-100 text-purple-800 border-purple-200'],
                                'completed' => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-800 border-green-200'],
                                'selesai' => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-800 border-green-200'],
                                'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800 border-red-200'],
                            ];
                            $currentStatus = $statusInfo[$purchase->status] ?? ['label' => ucfirst($purchase->status), 'class' => 'bg-gray-100 text-gray-800 border-gray-200'];
                        @endphp
                        <span class="text-sm font-semibold px-4 py-2 rounded-full border-2 {{ $currentStatus['class'] }} shadow-sm">
                            {{ $currentStatus['label'] }}
                        </span>
                        
                        <!-- Complete Order Button -->
                        @if($purchase->status === 'dikirim')
                            <button onclick="showCompleteModal()" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-2 rounded-full transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-check"></i>
                                Pesanan Selesai
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col lg:flex-row gap-6">
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $purchase->size->gambar_size) }}" 
                                 alt="{{ $purchase->product->nama_barang }}" 
                                 class="w-32 h-32 lg:w-40 lg:h-40 rounded-xl object-cover shadow-lg border border-gray-200">
                        </div>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">{{ $purchase->product->nama_barang }}</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-store text-orange-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 text-sm">Penjual</span>
                                        <p class="font-semibold text-gray-800">
                                            {{ $purchase->product->seller->nama_penjual ?? 'Tidak tersedia' }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-ruler-combined text-blue-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 text-sm">Ukuran</span>
                                        <p class="font-semibold text-gray-800">{{ $purchase->size->size }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-hashtag text-purple-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 text-sm">Jumlah</span>
                                        <p class="font-semibold text-gray-800">{{ $purchase->quantity }} pcs</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-tags text-green-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 text-sm">Total Harga</span>
                                        <p class="font-bold text-xl text-green-600">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Information -->
            @if($purchase->delivery)
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-motorcycle text-white text-sm"></i>
                    </div>
                    Informasi Kurir
                </h3>
                <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nama Kurir</p>
                                <p class="font-semibold text-gray-800">{{ $purchase->delivery->nama }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-id-badge text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nomor Seri Kurir</p>
                                <p class="font-mono text-sm bg-gray-100 px-3 py-1 rounded-lg font-semibold text-gray-800">
                                    {{ $purchase->delivery->delivery_serial }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-route text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status Pengiriman</p>
                                <p class="font-semibold text-gray-800 capitalize">
                                {{ $purchase->status_pengiriman ?? 'Belum ada info' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Shipping Information -->
            <div class="p-6 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-shipping-fast text-white text-sm"></i>
                    </div>
                    Detail Pengiriman
                </h3>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                    <i class="fas fa-user text-gray-400"></i>
                                    Penerima
                                </label>
                                <p class="mt-1 text-gray-900 font-semibold">{{ Auth::user()->name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                    <i class="fas fa-phone text-gray-400"></i>
                                    Nomor Telepon
                                </label>
                                <p class="mt-1 text-gray-900 font-semibold">{{ $purchase->phone_number }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                    <i class="fas fa-credit-card text-gray-400"></i>
                                    Metode Pembayaran
                                </label>
                                <p class="mt-1 text-gray-900 font-semibold">
                                    @switch($purchase->payment_method)
                                        @case('gopay')
                                            <span class="inline-flex items-center gap-2">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                Gopay
                                            </span>
                                            @break
                                        @case('dana')
                                            <span class="inline-flex items-center gap-2">
                                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                                Dana
                                            </span>
                                            @break
                                        @case('bank_transfer')
                                            <span class="inline-flex items-center gap-2">
                                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                                Transfer Bank
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center gap-2">
                                                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                                QRIS
                                            </span>
                                    @endswitch
                                </p>
                            </div>
                        </div>
                        
                        <div class="lg:col-span-2">
                            <label class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                                Alamat Pengiriman
                            </label>
                            <div class="mt-2 p-4 bg-gray-50 rounded-lg border-l-4 border-orange-500">
                                <p class="text-gray-900 leading-relaxed">{{ $purchase->shipping_address }}</p>
                            </div>
                        </div>
                        
                        @if($purchase->description)
                        <div class="lg:col-span-2">
                            <label class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                <i class="fas fa-sticky-note text-gray-400"></i>
                                Catatan Pembelian
                            </label>
                            <div class="mt-2 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                                <p class="text-gray-900 leading-relaxed italic">{{ $purchase->description }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Rating Form (if completed) -->
            @if($purchase->status === 'completed')
            <div id="rating-form" class="border-t border-gray-200">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 text-white">
                    <h3 class="text-lg font-bold flex items-center gap-2">
                        <i class="fas fa-star"></i>
                        Bagaimana pendapatmu tentang produk ini?
                    </h3>
                    <p class="text-orange-100 text-sm mt-1">Berikan rating dan ulasan untuk membantu pembeli lain</p>
                </div>
                
                <div class="p-6 bg-white">
                    <form action="{{ route('purchases.rate', $purchase) }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Rating Anda</label>
                            <div class="flex items-center space-x-2 rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="rating" value="{{ $i }}" class="sr-only" required>
                                    <i class="fas fa-star text-4xl text-gray-300 group-hover:text-yellow-400 transition-all duration-200 transform group-hover:scale-110"></i>
                                </label>
                                @endfor
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Klik bintang untuk memberikan rating</p>
                        </div>
                        
                        <div>
                            <label for="review" class="block text-sm font-medium text-gray-700 mb-2">Ulasan (Opsional)</label>
                            <textarea id="review" name="review" rows="4" 
                                class="w-full border-gray-300 rounded-xl shadow-sm focus:border-orange-500 focus:ring-orange-500 resize-none transition-all duration-200" 
                                placeholder="Bagikan pengalaman Anda dengan produk ini... Apakah sesuai dengan ekspektasi? Bagaimana kualitasnya?"></textarea>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-3 px-8 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-paper-plane"></i>
                                Kirim Ulasan
                            </button>
                            <button type="button" onclick="document.getElementById('rating-form').style.display='none'" 
                                class="text-gray-600 hover:text-gray-800 py-3 px-8 rounded-xl border-2 border-gray-300 hover:border-gray-400 transition-all duration-200 font-medium">
                                Lewati
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Complete Order Modal -->
<div id="completeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all scale-95">
        <div class="p-8 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                <i class="fas fa-check-circle text-green-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Konfirmasi Pesanan Selesai</h3>
            <p class="text-gray-600 mb-8 leading-relaxed">Apakah Anda yakin pesanan ini sudah selesai dan barang sudah diterima dengan baik?</p>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <form action="{{ route('purchases.complete', $purchase) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-check"></i>
                        Ya, Selesai
                    </button>
                </form>
                <button onclick="hideCompleteModal()" class="flex-1 text-gray-600 hover:text-gray-800 py-3 px-6 rounded-xl border-2 border-gray-300 hover:border-gray-400 transition-all duration-200 font-medium">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Modal functions
    function showCompleteModal() {
        const modal = document.getElementById('completeModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            modal.querySelector('.transform').classList.remove('scale-95');
            modal.querySelector('.transform').classList.add('scale-100');
        }, 10);
    }

    function hideCompleteModal() {
        const modal = document.getElementById('completeModal');
        modal.querySelector('.transform').classList.remove('scale-100');
        modal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 200);
    }

    // Close modal on outside click
    document.getElementById('completeModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideCompleteModal();
        }
    });

    // Rating stars interaction
    document.addEventListener('DOMContentLoaded', function() {
        const ratingContainer = document.querySelector('.rating-stars');
        if (ratingContainer) {
            const stars = ratingContainer.querySelectorAll('label i');
            const radioInputs = ratingContainer.querySelectorAll('input[name="rating"]');
            
            // Hover effect
            ratingContainer.addEventListener('mouseover', (e) => {
                if (e.target.tagName === 'I') {
                    const hoverIndex = Array.from(stars).indexOf(e.target);
                    stars.forEach((star, index) => {
                        if (index <= hoverIndex) {
                            star.classList.remove('text-gray-300', 'text-yellow-400');
                            star.classList.add('text-yellow-300');
                        } else {
                            star.classList.remove('text-yellow-300', 'text-yellow-400');
                            star.classList.add('text-gray-300');
                        }
                    });
                }
            });

            // Mouse leave effect
            ratingContainer.addEventListener('mouseleave', () => {
                const checkedInput = ratingContainer.querySelector('input[name="rating"]:checked');
                if (checkedInput) {
                    const checkedIndex = parseInt(checkedInput.value) - 1;
                    stars.forEach((star, index) => {
                        if (index <= checkedIndex) {
                            star.classList.remove('text-gray-300', 'text-yellow-300');
                            star.classList.add('text-yellow-400');
                        } else {
                            star.classList.remove('text-yellow-300', 'text-yellow-400');
                            star.classList.add('text-gray-300');
                        }
                    });
                } else {
                    stars.forEach(star => {
                        star.classList.remove('text-yellow-300', 'text-yellow-400');
                        star.classList.add('text-gray-300');
                    });
                }
            });

            // Click effect
            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    radioInputs[index].checked = true;
                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.classList.remove('text-gray-300', 'text-yellow-300');
                            s.classList.add('text-yellow-400');
                        } else {
                            s.classList.remove('text-yellow-300', 'text-yellow-400');
                            s.classList.add('text-gray-300');
                        }
                    });
                });
            });
        }
    });

    // Escape key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideCompleteModal();
        }
    });
</script>
</body>
</html>
@endsection