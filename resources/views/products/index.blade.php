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
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
            background-color: #fafafa;
        }
        
        h1 {
            font-size: clamp(20px, 4vw, 28px);
            margin: 30px 20px 15px;
            font-weight: 600;
        }
        
        h2 {
            font-size: clamp(18px, 3.5vw, 24px);
            margin: 30px 20px 15px;
            text-align: left;
            font-weight: 600;
        }
        
        a {
            text-decoration: none;
            color: inherit;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .section {
            padding: 40px 0;
        }
        
        .header-wrapper {
            margin-bottom: 30px;
        }
        
        .hero-section {
            position: relative;
            height: clamp(250px, 40vw, 350px);
            background-image: url('/banner.png');
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 clamp(20px, 5vw, 50px);
        }
        
        .hero-section h1 {
            font-size: clamp(28px, 6vw, 48px);
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
            margin: 0;
        }
        
        .features-title {
            font-size: clamp(16px, 3vw, 20px);
            font-weight: 600;
            margin: 30px 20px 20px;
            text-align: left;
        }
        
        .features-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            padding: 0 20px;
            margin-bottom: 20px;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }
        
        .feature-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        
        .icon-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #f8f9fa;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .icon-container i {
            color: #FF9800;
            font-size: 20px;
        }
        
        .icon-container.orange {
            background-color: #FF9800;
            transition: all 0.3s ease;
        }
        
        .icon-container.orange:hover {
            background-color: #f57c00;
            transform: scale(1.1);
        }
        
        .icon-container.orange i {
            color: white;
        }
        
        .feature-text {
            flex: 1;
            padding-right: 10px;
        }
        
        .feature-text h3 {
            margin: 0 0 8px 0;
            font-size: clamp(14px, 2.5vw, 16px);
            font-weight: 600;
            color: #333;
        }
        
        .feature-text p {
            margin: 0;
            font-size: clamp(12px, 2vw, 14px);
            color: #6c757d;
            line-height: 1.4;
        }

        .products-container, .discount-container {
            position: relative;
            padding: 0 20px;
            margin-bottom: 20px;
        }

        .products-grid, .discount-grid {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            padding: 20px 0;
            gap: clamp(10px, 2vw, 20px);
            scrollbar-width: thin;
            scrollbar-color: #FF9800 #f1f1f1;
        }

        .products-grid::-webkit-scrollbar,
        .discount-grid::-webkit-scrollbar {
            height: 6px;
        }

        .products-grid::-webkit-scrollbar-thumb,
        .discount-grid::-webkit-scrollbar-thumb {
            background-color: #FF9800;
            border-radius: 20px;
        }

        .products-grid::-webkit-scrollbar-track,
        .discount-grid::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 20px;
        }

        .product-card {
            flex: 0 0 clamp(180px, 25vw, 220px);
            border: 1px solid #e8e8e8;
            padding: 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-color: #FF9800;
        }

        .product-card img {
            width: 100%;
            height: clamp(150px, 20vw, 200px);
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 12px;
        }
        
        .product-card h3 {
            margin: 0 0 8px 0;
            font-size: clamp(14px, 2.5vw, 16px);
            font-weight: 600;
            color: #333;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-card p {
            color: #666;
            font-size: clamp(12px, 2vw, 14px);
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .product-price {
            font-weight: 700;
            color: #FF9800;
            font-size: clamp(14px, 2.5vw, 18px);
            margin-bottom: 10px;
        }
        
        .rating {
            color: #ffd700;
            margin-top: 8px;
            font-size: clamp(12px, 2vw, 14px);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .rating span {
            color: #666;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .discount-card {
            flex: 0 0 clamp(200px, 30vw, 280px);
            position: relative;
            height: clamp(150px, 25vw, 220px);
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }

        .discount-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .discount-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .discount-card:hover img {
            transform: scale(1.08);
        }

        .discount-card .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 40%, rgba(0, 0, 0, 0.8));
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 20px;
        }
        
        .discount-card h3 {
            margin: 0;
            font-size: clamp(14px, 2.5vw, 18px);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }
        
        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: clamp(35px, 5vw, 45px);
            height: clamp(35px, 5vw, 45px);
            background: rgba(255, 152, 0, 0.9);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: clamp(14px, 2.5vw, 18px);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            opacity: 0.8;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }
        
        .scroll-btn:hover {
            opacity: 1;
            background: rgba(255, 152, 0, 1);
            transform: translateY(-50%) scale(1.1);
        }
        
        .scroll-left {
            left: 10px;
        }
        
        .scroll-right {
            right: 10px;
        }

        .location-section {
            padding: 40px 20px;
            background-color: #f8f9fa;
            margin-top: 40px;
        }
        
        .location-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: start;
        }
        
        .map {
            width: 100%;
        }
        
        .map h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: clamp(18px, 3vw, 24px);
        }
        
        .map iframe {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .address {
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .address h3 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: clamp(24px, 4vw, 32px);
            color: #333;
            font-weight: 700;
        }
        
        .address p {
            margin: 8px 0;
            font-size: clamp(16px, 2.5vw, 20px);
            color: #666;
            line-height: 1.5;
        }
        
        .seller-info {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: clamp(12px, 2vw, 14px);
            margin: 8px 0;
        }

        .seller-info i {
            color: #666;
        }

        .no-favorites-message {
            text-align: center;
            padding: 40px 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            margin: 20px 0;
        }

        .no-favorites-message i {
            font-size: clamp(24px, 4vw, 32px);
            color: #d3d3d3;
            margin-bottom: 15px;
        }

        .no-favorites-message p:first-of-type {
            font-size: clamp(16px, 2.5vw, 18px);
            color: #6c757d;
            margin-bottom: 10px;
        }

        .no-favorites-message p:last-of-type {
            font-size: clamp(12px, 2vw, 14px);
            color: #6c757d;
            margin-top: 10px;
        }

        /* Mobile Responsive Improvements */
        @media (max-width: 768px) {
            .container {
                padding: 0 10px;
            }
            
            .features-section {
                grid-template-columns: 1fr;
                padding: 0 15px;
            }
            
            .feature-item {
                padding: 15px;
            }
            
            .products-container, .discount-container {
                padding: 0 15px;
            }
            
            .location-content {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .address {
                padding: 20px;
            }
            
            .scroll-btn {
                display: none;
            }
            
            .hero-section {
                padding: 0 20px;
            }
        }

        @media (max-width: 480px) {
            .features-section {
                padding: 0 10px;
            }
            
            .products-container, .discount-container {
                padding: 0 10px;
            }
            
            .location-section {
                padding: 20px 10px;
            }
            
            .feature-item {
                flex-direction: column;
                text-align: center;
                padding: 20px 15px;
            }
            
            .icon-container {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .feature-text {
                padding-right: 0;
            }
        }

        /* Performance optimizations */
        .product-card,
        .discount-card,
        .feature-item {
            will-change: transform;
        }

        /* Smooth scrolling for all browsers */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>
    <div class="header-wrapper">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1>Hello World</h1>
        </div>

        <h2 class="features-title">Keunggulan Kami</h2>
        
        <!-- Features Section -->
        <div class="features-section">
            <div class="feature-item">
                <div class="icon-container">
                    <i class="fas fa-users"></i>
                </div>
                <div class="feature-text">
                    <h3>Kami tersedia diberbagai platform</h3>
                    <p>Lorem ipsum sumipsum</p>
                </div>
                <a href="#Locate">
                    <div class="icon-container orange">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <div class="feature-item">
                <div class="icon-container">
                    <i class="fas fa-store"></i>
                </div>
                <div class="feature-text">
                    <h3>Store terbaik</h3>
                    <p>Lorem ipsum sumipsum</p>
                </div>
                <a href="#BiggestRating">
                    <div class="icon-container orange">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a> 
            </div>
            
            <div class="feature-item">
                <div class="icon-container">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="feature-text">
                    <h3>Harga Bersaing</h3>
                    <p>Lorem ipsum sumipsum</p>
                </div>
                <div class="icon-container orange">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Discount Categories Section -->
    <section class="section">
        <h1>Category</h1>
        <div class="discount-container">
            <button class="scroll-btn scroll-left" onclick="scrollContainer('discount-grid', 'left')">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="discount-grid" id="discount-grid">
                @foreach($categories as $category)
                <a href="{{ route('products.category', $category->id) }}" class="discount-card">
                    <img src="{{ $category->gambar }}" alt="{{ $category->nama }}">
                    <div class="overlay">
                        <h3>{{ $category->nama }}</h3>
                    </div>
                </a>
                @endforeach
            </div>
            <button class="scroll-btn scroll-right" onclick="scrollContainer('discount-grid', 'right')">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </section>

    <!-- Favorite Products Section -->
    <section class="section" id="BiggestRating">
        <h1>Barang Favorit Kami</h1>
        <div class="products-container">
            @if(count($products) > 0)
            <button class="scroll-btn scroll-left" onclick="scrollContainer('products-grid', 'left')">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="products-grid" id="products-grid">
                @foreach($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="product-card">
                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_barang }}">
                    <h3>{{ $product->nama_barang }}</h3>
                    @php
                        $smallestSize = $product->sizes->sortBy('harga')->first();
                        $priceRange = 'Rp '. number_format($smallestSize->harga, 0, ',', '.');
                    @endphp
                    <div class="product-price">{{ $priceRange }}</div>
                    <div class="rating">
                        <i class="fas fa-star"></i>    
                        {{ number_format($product->ratings->avg('rating') ?? 0, 1) }}
                        <span>
                            <i class="fas fa-shopping-cart"></i> {{ $product->purchase_count ?? 0 }} terjual
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
            <button class="scroll-btn scroll-right" onclick="scrollContainer('products-grid', 'right')">
                <i class="fas fa-chevron-right"></i>
            </button>
            @else
                <div class="no-favorites-message">
                    <i class="fas fa-star"></i>
                    <p>Belum ada produk favorit dengan rating tinggi saat ini.</p>
                    <p>Produk dengan rating 4.0 ke atas akan ditampilkan di sini.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Location Section -->
    <section class="location-section" id="Locate">
        <div class="location-content">
            <div class="map">
                <h2>Lokasi Kantor Kami</h2>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.9871065035472!2d112.72276627605149!3d-7.466674473607052!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e6d71181af21%3A0x4232ab0204ccbfe5!2sSMK%20TELKOM%20Sidoarjo!5e0!3m2!1sid!2sid!4v1740023359217!5m2!1sid!2sid"
                    width="100%"
                    height="350"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            </div>
            <div class="address">
                <h3>SMK Telkom Sidoarjo</h3>
                <p>Sekardangan</p>
                <p>RT 00 RW 99</p>
            </div>
        </div>
    </section>

    <script>
        function scrollContainer(containerId, direction) {
            const container = document.getElementById(containerId);
            const scrollAmount = container.clientWidth * 0.8; // Responsive scroll amount
            
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