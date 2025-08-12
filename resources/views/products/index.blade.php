@extends ('layouts.app')

@section ('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom scrollbar styles untuk webkit browsers */
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #f59e0b;
            border-radius: 20px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 20px;
        }
        
        /* Custom gradient overlay */
        .gradient-overlay {
            background: linear-gradient(to bottom, transparent 40%, rgba(0, 0, 0, 0.8));
        }
        
        /* Custom clamp utilities */
        .text-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-800 leading-relaxed">
    <div class="mb-8">
        <!-- Hero Section -->
        <div class="relative h-64 md:h-80 lg:h-96 bg-cover bg-center flex items-center px-5 md:px-12 text-white" 
             style="background-image: url('/banner.png')">
            <h1 class="text-2xl md:text-4xl lg:text-5xl font-extrabold drop-shadow-lg">
                Temukan Gaya Terbaikmu
            </h1>
        </div>

        <h2 class="text-lg md:text-xl lg:text-2xl font-semibold mt-8 mb-5 mx-5 text-left">
            Keunggulan Kami
        </h2>
        
        <!-- Features Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 px-5 mb-5">
            <div class="flex flex-col md:flex-row items-center p-5 bg-white rounded-xl shadow-lg border border-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mr-0 md:mr-4 mb-4 md:mb-0 flex-shrink-0">
                    <i class="fas fa-users text-orange-500 text-xl"></i>
                </div>
                <div class="flex-1 text-center md:text-left pr-0 md:pr-3">
                    <h3 class="text-sm md:text-base font-semibold text-gray-800 mb-2">
                        Kami tersedia diberbagai platform
                    </h3>
                    <p class="text-xs md:text-sm text-gray-500">
                        Lorem ipsum sumipsum
                    </p>
                </div>
                <a href="#Locate">
                    <div class="flex items-center justify-center w-12 h-12 bg-orange-500 rounded-full text-white transition-all duration-300 hover:bg-orange-600 hover:scale-110 shadow-md">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <div class="flex flex-col md:flex-row items-center p-5 bg-white rounded-xl shadow-lg border border-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mr-0 md:mr-4 mb-4 md:mb-0 flex-shrink-0">
                    <i class="fas fa-store text-orange-500 text-xl"></i>
                </div>
                <div class="flex-1 text-center md:text-left pr-0 md:pr-3">
                    <h3 class="text-sm md:text-base font-semibold text-gray-800 mb-2">
                        Store terbaik
                    </h3>
                    <p class="text-xs md:text-sm text-gray-500">
                        Lorem ipsum sumipsum
                    </p>
                </div>
                <a href="#BiggestRating">
                    <div class="flex items-center justify-center w-12 h-12 bg-orange-500 rounded-full text-white transition-all duration-300 hover:bg-orange-600 hover:scale-110 shadow-md">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a> 
            </div>
            
            <div class="flex flex-col md:flex-row items-center p-5 bg-white rounded-xl shadow-lg border border-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mr-0 md:mr-4 mb-4 md:mb-0 flex-shrink-0">
                    <i class="fas fa-tag text-orange-500 text-xl"></i>
                </div>
                <div class="flex-1 text-center md:text-left pr-0 md:pr-3">
                    <h3 class="text-sm md:text-base font-semibold text-gray-800 mb-2">
                        Harga Bersaing
                    </h3>
                    <p class="text-xs md:text-sm text-gray-500">
                        Lorem ipsum sumipsum
                    </p>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-orange-500 rounded-full text-white transition-all duration-300 hover:bg-orange-600 hover:scale-110 shadow-md">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Discount Categories Section -->
    <section class="py-10">
        <h1 class="text-xl md:text-2xl lg:text-3xl font-semibold mt-8 mb-4 mx-5">Category</h1>
        <div class="relative px-5 mb-5">
            <button class="absolute left-3 top-1/2 transform -translate-y-1/2 w-9 h-9 md:w-11 md:h-11 bg-orange-500 bg-opacity-90 border-none rounded-full text-white flex items-center justify-center cursor-pointer z-10 opacity-80 transition-all duration-300 hover:opacity-100 hover:bg-orange-500 hover:scale-110 shadow-lg hidden md:flex"
                    onclick="scrollContainer('discount-grid', 'left')">
                <i class="fas fa-chevron-left text-sm md:text-lg"></i>
            </button>
            <div class="flex overflow-x-auto scroll-smooth py-5 gap-3 md:gap-5 custom-scrollbar" id="discount-grid">
                @foreach($categories as $category)
                <a href="{{ route('products.category', $category->id) }}" class="flex-none w-50 md:w-60 lg:w-70 relative h-36 md:h-48 lg:h-56 overflow-hidden rounded-xl shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                    <img src="{{ $category->gambar }}" alt="{{ $category->nama }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                    <div class="absolute inset-0 gradient-overlay text-white flex flex-col justify-end p-5">
                        <h3 class="text-sm md:text-lg font-bold uppercase tracking-wide">{{ $category->nama }}</h3>
                    </div>
                </a>
                @endforeach
            </div>
            <button class="absolute right-3 top-1/2 transform -translate-y-1/2 w-9 h-9 md:w-11 md:h-11 bg-orange-500 bg-opacity-90 border-none rounded-full text-white flex items-center justify-center cursor-pointer z-10 opacity-80 transition-all duration-300 hover:opacity-100 hover:bg-orange-500 hover:scale-110 shadow-lg hidden md:flex"
                    onclick="scrollContainer('discount-grid', 'right')">
                <i class="fas fa-chevron-right text-sm md:text-lg"></i>
            </button>
        </div>
    </section>

    <!-- Favorite Products Section -->
    <section class="py-10" id="BiggestRating">
        <h1 class="text-xl md:text-2xl lg:text-3xl font-semibold mt-8 mb-4 mx-5">Barang Favorit Kami</h1>
        <div class="relative px-5 mb-5">
            @if(count($products) > 0)
            <button class="absolute left-3 top-1/2 transform -translate-y-1/2 w-9 h-9 md:w-11 md:h-11 bg-orange-500 bg-opacity-90 border-none rounded-full text-white flex items-center justify-center cursor-pointer z-10 opacity-80 transition-all duration-300 hover:opacity-100 hover:bg-orange-500 hover:scale-110 shadow-lg hidden md:flex"
                    onclick="scrollContainer('products-grid', 'left')">
                <i class="fas fa-chevron-left text-sm md:text-lg"></i>
            </button>
            <div class="flex overflow-x-auto scroll-smooth py-5 gap-3 md:gap-5 custom-scrollbar" id="products-grid">
                @foreach($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="flex-none w-44 md:w-52 lg:w-56 border border-gray-200 p-4 rounded-xl transition-all duration-300 bg-white shadow-lg hover:-translate-y-2 hover:shadow-xl hover:border-orange-500">
                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_barang }}" class="w-full h-36 md:h-44 lg:h-48 object-cover rounded-lg mb-3">
                    <h3 class="text-sm md:text-base font-semibold text-gray-800 leading-tight text-clamp-2 mb-2">{{ $product->nama_barang }}</h3>
                    @php
                        $smallestSize = $product->sizes->sortBy('harga')->first();
                        $priceRange = 'Rp '. number_format($smallestSize->harga, 0, ',', '.');
                    @endphp
                    <div class="font-bold text-orange-500 text-sm md:text-lg mb-3">{{ $priceRange }}</div>
                    <div class="text-yellow-400 text-xs md:text-sm flex items-center gap-1">
                        <i class="fas fa-star"></i>    
                        {{ number_format($product->ratings->avg('rating') ?? 0, 1) }}
                        <span class="text-gray-500 flex items-center gap-1">
                            <i class="fas fa-shopping-cart"></i> {{ $product->purchase_count ?? 0 }} terjual
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
            <button class="absolute right-3 top-1/2 transform -translate-y-1/2 w-9 h-9 md:w-11 md:h-11 bg-orange-500 bg-opacity-90 border-none rounded-full text-white flex items-center justify-center cursor-pointer z-10 opacity-80 transition-all duration-300 hover:opacity-100 hover:bg-orange-500 hover:scale-110 shadow-lg hidden md:flex"
                    onclick="scrollContainer('products-grid', 'right')">
                <i class="fas fa-chevron-right text-sm md:text-lg"></i>
            </button>
            @else
                <div class="text-center py-10 bg-white rounded-xl shadow-lg mx-5">
                    <i class="fas fa-star text-2xl md:text-3xl text-gray-300 mb-4"></i>
                    <p class="text-base md:text-lg text-gray-500 mb-3">Belum ada produk favorit dengan rating tinggi saat ini.</p>
                    <p class="text-xs md:text-sm text-gray-500">Produk dengan rating 4.0 ke atas akan ditampilkan di sini.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Location Section -->
    <section class="py-10 bg-gray-100 mt-10" id="Locate">
        <div class="max-w-7xl mx-auto px-5">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
                <div class="w-full">
                    <h2 class="text-lg md:text-xl lg:text-2xl font-semibold mb-5">Lokasi Kantor Kami</h2>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.9871065035472!2d112.72276627605149!3d-7.466674473607052!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e6d71181af21%3A0x4232ab0204ccbfe5!2sSMK%20TELKOM%20Sidoarjo!5e0!3m2!1sid!2sid!4v1740023359217!5m2!1sid!2sid"
                        width="100%"
                        height="350"
                        class="border-0 rounded-xl shadow-lg"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
                <div class="p-6 md:p-8 bg-white rounded-xl shadow-lg">
                    <h3 class="text-xl md:text-2xl lg:text-3xl text-gray-800 font-bold mb-5">SMK Telkom Sidoarjo</h3>
                    <p class="text-base md:text-lg lg:text-xl text-gray-600 leading-relaxed mb-2">Sekardangan</p>
                    <p class="text-base md:text-lg lg:text-xl text-gray-600 leading-relaxed">RT 00 RW 99</p>
                </div>
            </div>
        </div>
    </section>

    <script>
        function scrollContainer(containerId, direction) {
            const container = document.getElementById(containerId);
            const scrollAmount = container.clientWidth * 0.8;
            
            if (direction === 'left') {
                container.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            } else {
                container.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            }
        }

        // Hide scroll buttons on mobile
        function handleResize() {
            const scrollBtns = document.querySelectorAll('.scroll-btn');
            if (window.innerWidth <= 768) {
                scrollBtns.forEach(btn => btn.style.display = 'none');
            } else {
                scrollBtns.forEach(btn => btn.style.display = 'flex');
            }
        }

        window.addEventListener('resize', handleResize);
        window.addEventListener('load', handleResize);
    </script>
</body>
</html>
@endsection