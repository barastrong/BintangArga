@extends('layouts.app')

@section('content')
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
                    @php
                        $statusInfo = [
                            'pending' => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-yellow-100 text-yellow-800'],
                            'diproses' => ['label' => 'Diproses', 'class' => 'bg-blue-100 text-blue-800'],
                            'process' => ['label' => 'Diproses', 'class' => 'bg-blue-100 text-blue-800'],
                            'dikirim' => ['label' => 'Dikirim', 'class' => 'bg-indigo-100 text-indigo-800'],
                            'completed' => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-800'],
                            'selesai' => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-800'],
                            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-800'],
                        ];
                        $currentStatus = $statusInfo[$purchase->status] ?? ['label' => ucfirst($purchase->status), 'class' => 'bg-gray-100 text-gray-800'];
                    @endphp
                    <span class="text-xs font-medium px-3 py-1 rounded-full {{ $currentStatus['class'] }}">{{ $currentStatus['label'] }}</span>
                </div>
            </div>

            <!-- Detail Item -->
            <div class="p-6">
                <div class="flex gap-4">
                    <img src="{{ asset('storage/' . $purchase->size->gambar_size) }}" alt="{{ $purchase->product->nama_barang }}" class="w-24 h-24 rounded-lg object-cover">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800">{{ $purchase->product->nama_barang }}</h3>
                        <p class="text-sm text-gray-500">Ukuran: {{ $purchase->size->size }}</p>
                        <p class="text-sm text-gray-500">Jumlah: {{ $purchase->quantity }}</p>
                    </div>
                    <p class="font-bold text-lg text-gray-800">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Detail Pengiriman -->
            <div class="p-6 border-t">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pengiriman</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 text-sm">
                    <div>
                        <dt class="text-gray-500">Penerima</dt>
                        <dd class="mt-1 text-gray-900 font-medium">{{ Auth::user()->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Nomor Telepon</dt>
                        <dd class="mt-1 text-gray-900 font-medium">{{ $purchase->phone_number }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-gray-500">Alamat Pengiriman</dt>
                        <dd class="mt-1 text-gray-900 font-medium">{{ $purchase->shipping_address }}</dd>
                    </div>
                    @if($purchase->description)
                    <div class="sm:col-span-2">
                        <dt class="text-gray-500">Catatan Pembelian</dt>
                        <dd class="mt-1 text-gray-900 font-medium">{{ $purchase->description }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Form Rating (jika status 'completed'/'selesai' dan belum dirating) -->
        @if(($purchase->status === 'completed' || $purchase->status === 'selesai') && !$purchase->has_been_rated)
        <div id="rating-form" class="mt-8 bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                Bagaimana pendapatmu tentang produk ini?
            </h3>
            <form action="{{ route('purchases.rate', $purchase) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating Anda</label>
                    <div class="flex items-center space-x-1 rating-stars">
                        @for ($i = 1; $i <= 5; $i++)
                        <label>
                            <input type="radio" name="rating" value="{{ $i }}" class="sr-only" required>
                            <i class="fas fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors"></i>
                        </label>
                        @endfor
                    </div>
                </div>
                <div class="mb-4">
                    <label for="review" class="block text-sm font-medium text-gray-700 mb-2">Ulasan (Opsional)</label>
                    <textarea id="review" name="review" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="Bagikan pengalaman Anda dengan produk ini..."></textarea>
                </div>
                
                <button type="submit" class="w-full sm:w-auto bg-orange-500 text-white font-bold py-2 px-4 rounded-md hover:bg-orange-600 transition">
                    Kirim Ulasan
                </button>
            </form>
        </div>
        @endif

    </div>
</div>

<script>
    // Script untuk interaksi bintang rating
    const ratingContainer = document.querySelector('.rating-stars');
    if (ratingContainer) {
        const stars = ratingContainer.querySelectorAll('label i');
        ratingContainer.addEventListener('mouseover', (e) => {
            if (e.target.tagName === 'I') {
                const hoverIndex = Array.from(stars).indexOf(e.target);
                stars.forEach((star, index) => {
                    star.classList.toggle('text-yellow-300', index <= hoverIndex);
                    star.classList.toggle('text-gray-300', index > hoverIndex);
                });
            }
        });

        ratingContainer.addEventListener('mouseout', () => {
            const checkedStar = ratingContainer.querySelector('input[name="rating"]:checked');
            if (checkedStar) {
                const checkedIndex = parseInt(checkedStar.value) - 1;
                stars.forEach((star, index) => {
                    star.classList.toggle('text-yellow-400', index <= checkedIndex);
                    star.classList.toggle('text-gray-300', index > checkedIndex);
                });
            } else {
                stars.forEach(star => {
                    star.classList.remove('text-yellow-300', 'text-yellow-400');
                    star.classList.add('text-gray-300');
                });
            }
        });

        ratingContainer.addEventListener('click', (e) => {
            if (e.target.tagName === 'I') {
                const clickedIndex = Array.from(stars).indexOf(e.target);
                stars.forEach((star, index) => {
                    star.classList.toggle('text-yellow-400', index <= clickedIndex);
                    star.classList.toggle('text-gray-300', index > clickedIndex);
                });
            }
        });
    }
</script>
@endsection