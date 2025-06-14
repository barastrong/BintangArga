@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <a href="{{ route('purchases.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Riwayat Pesanan</span>
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Detail Pesanan #{{ $purchase->id }}</h2>
                        <p class="text-sm text-gray-500">Dipesan pada {{ $purchase->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        @php
                            $statusInfo = [
                                'pending' => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-yellow-100 text-yellow-800'],
                                'diproses' => ['label' => 'Diproses', 'class' => 'bg-blue-100 text-blue-800'],
                                'process' => ['label' => 'Diproses', 'class' => 'bg-blue-100 text-blue-800'],
                                'dikirim' => ['label' => 'Dikirim', 'class' => 'bg-purple-100 text-purple-800'],
                                'completed' => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-800'],
                                'selesai' => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-800'],
                                'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800'],
                            ];
                            $currentStatus = $statusInfo[$purchase->status] ?? ['label' => ucfirst($purchase->status), 'class' => 'bg-gray-100 text-gray-800'];
                        @endphp
                        <span class="text-xs font-medium px-3 py-1 rounded-full {{ $currentStatus['class'] }}">{{ $currentStatus['label'] }}</span>
                        
                        <!-- Tombol Selesai - hanya muncul jika status 'dikirim' -->
                        @if($purchase->status === 'dikirim')
                            <button onclick="showCompleteModal()" class="bg-green-500 hover:bg-green-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                                <i class="fas fa-check"></i>
                                Pesanan Selesai
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detail Item -->
            <div class="p-6">
                <div class="flex gap-6">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $purchase->size->gambar_size) }}" alt="{{ $purchase->product->nama_barang }}" class="w-28 h-28 rounded-lg object-cover shadow-sm">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $purchase->product->nama_barang }}</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Penjual:</span>
                                <span class="ml-2 font-medium text-gray-700">
                                    @if($purchase->product->seller)
                                        {{ $purchase->product->seller->nama_penjual }}
                                    @else
                                        Tidak tersedia
                                    @endif
                                </span>
                            </div>
                            
                            <div>
                                <span class="text-gray-500">Nomor Seri:</span>
                                <span class="ml-2 font-mono text-sm bg-gray-100 px-2 py-1 rounded font-medium">
                                    @if($purchase->seller->nomor_seri)
                                        {{ $purchase->seller->nomor_seri }}
                                    @else
                                        <span class="text-gray-400">Belum tersedia</span>
                                    @endif
                                </span>
                            </div>
                            
                            <div>
                                <span class="text-gray-500">Ukuran:</span>
                                <span class="ml-2 font-medium text-gray-700">{{ $purchase->size->size }}</span>
                            </div>
                            
                            <div>
                                <span class="text-gray-500">Jumlah:</span>
                                <span class="ml-2 font-medium text-gray-700">{{ $purchase->quantity }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 text-right">
                        <p class="text-lg font-bold text-gray-800">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500 mt-1">Total Harga</p>
                    </div>
                </div>
            </div>

            <!-- Detail Pengiriman -->
            <div class="p-6 border-t bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-shipping-fast text-orange-500"></i>
                    Informasi Pengiriman
                </h3>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div>
                            <dt class="text-gray-500 font-medium">Penerima</dt>
                            <dd class="mt-1 text-gray-900">{{ Auth::user()->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 font-medium">Nomor Telepon</dt>
                            <dd class="mt-1 text-gray-900">{{ $purchase->phone_number }}</dd>
                        </div>
                        <div>
                            @if($purchase->payment_method === 'gopay')
                                <dt class="text-gray-500 font-medium">Metode Pembayaran</dt>
                                <dd class="mt-1 text-gray-900">Gopay</dd>
                            @elseif($purchase->payment_method === 'dana')
                                <dt class="text-gray-500 font-medium">Metode Pembayaran</dt>
                                <dd class="mt-1 text-gray-900">Dana</dd>
                            @elseif($purchase->payment_method === 'bank_transfer')
                                <dt class="text-gray-500 font-medium">Metode Pembayaran</dt>
                                <dd class="mt-1 text-gray-900">Transfer Bank</dd>
                            @else
                                <dt class="text-gray-500 font-medium">Metode Pembayaran</dt>
                                <dd class="mt-1 text-gray-900">QRIS</dd>
                            @endif
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-gray-500 font-medium">Alamat Pengiriman</dt>
                            <dd class="mt-1 text-gray-900 leading-relaxed">{{ $purchase->shipping_address }}</dd>
                        </div>
                        @if($purchase->description)
                        <div class="sm:col-span-2">
                            <dt class="text-gray-500 font-medium">Catatan Pembelian</dt>
                            <dd class="mt-1 text-gray-900 leading-relaxed bg-gray-50 p-3 rounded-md">{{ $purchase->description }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Form Rating (jika status 'completed'/'selesai' dan belum dirating) -->
            @if($purchase->status === 'completed')
            <div id="rating-form" class="mt-8 bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 text-white">
                    <h3 class="text-lg font-medium flex items-center gap-2">
                        <i class="fas fa-star"></i>
                        Bagaimana pendapatmu tentang produk ini?
                    </h3>
                    <p class="text-orange-100 text-sm mt-1">Berikan rating dan ulasan untuk membantu pembeli lain</p>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('purchases.rate', $purchase) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Rating Anda</label>
                            <div class="flex items-center space-x-1 rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" class="sr-only" required>
                                    <i class="fas fa-star text-3xl text-gray-300 hover:text-yellow-400 transition-colors duration-200"></i>
                                </label>
                                @endfor
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Klik bintang untuk memberikan rating</p>
                        </div>
                        
                        <div class="mb-6">
                            <label for="review" class="block text-sm font-medium text-gray-700 mb-2">Ulasan (Opsional)</label>
                            <textarea id="review" name="review" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 resize-none" placeholder="Bagikan pengalaman Anda dengan produk ini... Apakah sesuai dengan ekspektasi? Bagaimana kualitasnya?"></textarea>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" class="bg-orange-500 text-white font-medium py-3 px-6 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center justify-center gap-2">
                                <i class="fas fa-paper-plane"></i>
                                Kirim Ulasan
                            </button>
                            <button type="button" onclick="document.getElementById('rating-form').style.display='none'" class="text-gray-500 hover:text-gray-700 py-3 px-6 rounded-lg border border-gray-300 hover:border-gray-400 transition-colors duration-200">
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

<!-- Modal Konfirmasi Selesai -->
 
<div id="completeModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                <i class="fas fa-check-circle text-green-500 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi Pesanan Selesai</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin pesanan ini sudah selesai dan barang sudah diterima dengan baik?</p>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <form action="{{ route('purchases.complete', $purchase) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-check"></i>
                        Ya, Selesai
                    </button>
                </form>
                <button onclick="hideCompleteModal()" class="flex-1 text-gray-500 hover:text-gray-700 py-3 px-6 rounded-lg border border-gray-300 hover:border-gray-400 transition-colors duration-200">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Script untuk modal konfirmasi selesai
    function showCompleteModal() {
        document.getElementById('completeModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function hideCompleteModal() {
        document.getElementById('completeModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Tutup modal jika klik di luar modal
    document.getElementById('completeModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideCompleteModal();
        }
    });

    // Script untuk interaksi bintang rating
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
</script>
</body>
</html>
@endsection