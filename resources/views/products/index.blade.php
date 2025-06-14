@extends ('layouts.app')

@section ('content')

<!-- Hero Section -->
<header class="relative h-[60vh] md:h-[80vh] bg-cover bg-center" style="background-image: url('/banner1.png');">
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    <div class="relative h-full flex items-center justify-center text-center px-4">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white tracking-tight drop-shadow-lg">
            Temukan Gaya Terbaikmu
        </h1>
    </div>
</header>

<br>
<br>
<div class="bg-gray-50">

    <!-- Features Section -->
    <section class="py-16 sm:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center">Keunggulan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Kartu Keunggulan 1 --}}
                <div class="flex items-center p-6 bg-white rounded-xl shadow-md border border-gray-100">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 text-orange-500">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900">Multi-Platform</h3>
                        <p class="text-sm text-gray-500 mt-1">Temukan kami dengan mudah.</p>
                    </div>
                </div>
                {{-- Kartu Keunggulan 2 --}}
                <div class="flex items-center p-6 bg-white rounded-xl shadow-md border border-gray-100">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 text-orange-500">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900">Store Terbaik</h3>
                        <p class="text-sm text-gray-500 mt-1">Kualitas produk terjamin.</p>
                    </div>
                </div>
                {{-- Kartu Keunggulan 3 --}}
                <div class="flex items-center p-6 bg-white rounded-xl shadow-md border border-gray-100">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 text-orange-500">
                        <i class="fas fa-tag text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900">Harga Bersaing</h3>
                        <p class="text-sm text-gray-500 mt-1">Kualitas premium, harga pas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center">Kategori Pilihan</h2>
            <div class="relative">
                <button class="scroll-btn left-0" onclick="scrollContainer('discount-grid', 'left')">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div id="discount-grid" class="flex space-x-6 overflow-x-auto pb-4 scroll-smooth snap-x snap-mandatory custom-scrollbar">
                    @foreach($categories as $category)
                    <a href="{{ route('products.category', $category->id) }}" class="snap-start flex-shrink-0 w-64 md:w-72 group">
                        <div class="relative rounded-xl overflow-hidden shadow-lg transform group-hover:scale-105 transition-all duration-300">
                            <img src="{{ $category->gambar }}" alt="{{ $category->nama }}" class="h-80 w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-4">
                                <h3 class="text-white text-xl font-bold tracking-wide">{{ $category->nama }}</h3>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <button class="scroll-btn right-0" onclick="scrollContainer('discount-grid', 'right')">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Favorite Products Section -->
    <section class="py-16 sm:py-20" id="BiggestRating">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center">Barang Favorit Kami</h2>
            @if($products->isEmpty())
                <div class="text-center py-16 px-6 bg-white rounded-lg shadow-sm">
                    <i class="fas fa-star text-5xl text-gray-300 mb-4"></i>
                    <p class="text-lg text-gray-600">Belum ada produk favorit saat ini.</p>
                    <p class="text-sm text-gray-500 mt-1">Produk dengan rating tinggi akan tampil di sini.</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="bg-white rounded-xl shadow-md overflow-hidden group transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_barang }}" class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 truncate" title="{{ $product->nama_barang }}">{{ $product->nama_barang }}</h3>
                            @php
                                $smallestSize = $product->sizes->sortBy('harga')->first();
                                $priceRange = $smallestSize ? 'Rp '. number_format($smallestSize->harga, 0, ',', '.') : 'N/A';
                            @endphp
                            <p class="text-lg font-bold text-orange-500 mt-1">{{ $priceRange }}</p>
                            <div class="flex items-center text-sm text-gray-500 mt-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="ml-1 font-semibold">{{ number_format($product->ratings->avg('rating') ?? 0, 1) }}</span>
                                <span class="mx-2">|</span>
                                <span>{{ $product->purchase_count ?? 0 }} terjual</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Location Section -->
    <section class="py-16 sm:py-20 bg-white" id="Locate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="p-8 md:p-12 flex flex-col justify-center text-center lg:text-left">
                        <h2 class="text-3xl font-bold text-gray-800">Kunjungi Kantor Kami</h2>
                        <div class="mt-6 space-y-2">
                            <h3 class="text-xl font-semibold text-orange-600">SMK Telkom Sidoarjo</h3>
                            <p class="text-gray-600">Jl. Raya Pecantingan, Sekardangan</p>
                            <p class="text-gray-600">Sidoarjo, Jawa Timur, 61215</p>
                        </div>
                    </div>
                    <div class="h-80 lg:h-full">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.9871065035472!2d112.72276627605149!3d-7.466674473607052!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e6d71181af21%3A0x4232ab0204ccbfe5!2sSMK%20TELKOM%20Sidoarjo!5e0!3m2!1sid!2sid!4v1740023359217!5m2!1sid!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- CSS dan JS untuk scroll button --}}
<style>
    /* Menyembunyikan scrollbar bawaan */
    .custom-scrollbar::-webkit-scrollbar { display: none; }
    .custom-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Styling untuk tombol scroll kustom */
    .scroll-btn {
        @apply absolute top-1/2 -translate-y-1/2 z-20 bg-white/70 backdrop-blur-sm rounded-full w-12 h-12 flex items-center justify-center shadow-lg text-gray-700 hover:bg-white hover:text-orange-500 transition-all duration-300;
    }
    /* Sembunyikan di mobile, tampilkan di desktop */
    @media (max-width: 768px) {
        .scroll-btn { display: none; }
    }
</style>

<script>
    function scrollContainer(containerId, direction) {
        const container = document.getElementById(containerId);
        // Scroll sebesar 80% dari lebar container yang terlihat
        const scrollAmount = container.clientWidth * 0.8;
        
        container.scrollBy({
            left: direction === 'left' ? -scrollAmount : scrollAmount,
            behavior: 'smooth'
        });
    }
</script>
@endsection