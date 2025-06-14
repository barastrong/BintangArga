@extends ('layouts.app')

@section ('content')

<!-- Hero Section -->
<header class="relative h-[60vh] md:h-[70vh] bg-cover bg-center" style="background-image: url('/banner.png');">
    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
    <div class="relative h-full flex items-center justify-center text-center px-4">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white tracking-tight drop-shadow-lg">
            Temukan Gaya Terbaikmu
        </h1>
    </div>
</header>

<div class="py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Features Section -->
        <section>
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Keunggulan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <a href="#location" class="block bg-white p-6 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 text-orange-500">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Multi-Platform</h3>
                            <p class="text-gray-500 mt-1">Temukan kami dengan mudah.</p>
                        </div>
                    </div>
                </a>
                <a href="#favorites" class="block bg-white p-6 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 text-orange-500">
                            <i class="fas fa-store text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Store Terbaik</h3>
                            <p class="text-gray-500 mt-1">Kualitas produk terjamin.</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="block bg-white p-6 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 text-orange-500">
                            <i class="fas fa-tag text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Harga Bersaing</h3>
                            <p class="text-gray-500 mt-1">Kualitas premium, harga pas.</p>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="mt-16 md:mt-24" id="categories">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Kategori Pilihan</h2>
            <div class="relative">
                <div id="discount-grid" class="flex space-x-6 overflow-x-auto pb-4 -mx-4 px-4 scrollbar-hide">
                    @foreach($categories as $category)
                    <a href="{{ route('products.category', $category->id) }}" class="flex-shrink-0 w-60 md:w-72 group">
                        <div class="relative rounded-xl overflow-hidden shadow-lg transform group-hover:scale-105 group-hover:shadow-2xl transition-all duration-300">
                            <img src="{{ $category->gambar }}" alt="{{ $category->nama }}" class="h-40 w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-4">
                                <h3 class="text-white text-xl font-bold tracking-wide">{{ $category->nama }}</h3>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Favorite Products Section -->
        <section class="mt-16 md:mt-24" id="favorites">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Barang Favorit Kami</h2>
            @if(count($products) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="bg-white rounded-xl shadow-md overflow-hidden group transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_barang }}" class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 truncate">{{ $product->nama_barang }}</h3>
                            @php
                                $smallestSize = $product->sizes->sortBy('harga')->first();
                                $priceRange = 'Rp '. number_format($smallestSize->harga, 0, ',', '.');
                            @endphp
                            <p class="text-lg font-bold text-orange-500 mt-1">{{ $priceRange }}</p>
                            <div class="flex items-center text-sm text-gray-500 mt-2">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="ml-1">{{ number_format($product->ratings->avg('rating') ?? 0, 1) }}</span>
                                <span class="mx-2">|</span>
                                <span>{{ $product->purchase_count ?? 0 }} terjual</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 px-6 bg-white rounded-lg shadow-md">
                    <i class="fas fa-star text-5xl text-gray-300 mb-4"></i>
                    <p class="text-lg text-gray-600">Belum ada produk favorit saat ini.</p>
                    <p class="text-sm text-gray-500 mt-1">Produk dengan rating tinggi akan tampil di sini.</p>
                </div>
            @endif
        </section>

        <!-- Location Section -->
        <section class="mt-16 md:mt-24 bg-white rounded-xl shadow-lg overflow-hidden" id="location">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <h2 class="text-3xl font-bold text-gray-800">Kunjungi Kantor Kami</h2>
                    <div class="mt-6 space-y-2">
                        <h3 class="text-xl font-semibold text-orange-600">SMK Telkom Sidoarjo</h3>
                        <p class="text-gray-600">Jl. Raya Pecantingan, Sekardangan</p>
                        <p class="text-gray-600">Sidoarjo, Jawa Timur, 61215</p>
                    </div>
                </div>
                <div class="h-64 lg:h-full">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.9871065035472!2d112.72276627605149!3d-7.466674473607052!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e6d71181af21%3A0x4232ab0204ccbfe5!2sSMK%20TELKOM%20Sidoarjo!5e0!3m2!1sid!2sid!4v1740023359217!5m2!1sid!2sid"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection