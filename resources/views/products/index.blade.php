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
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        
        h1{
            font-size: 24px;
            margin: 30px 20px 15px;
        }
        h2 {
            font-size: 24px;
            margin: 30px 20px 15px;
            text-align: left;
        }
        
        a {
            text-decoration: none;
            color: inherit;
        }
        
        .header-wrapper {
            margin-bottom: 30px;
        }
        
        .hero-section {
            position: relative;
            height: 300px;
            background-image: url('/storage/banner.png');
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 50px;
        }
        
        .hero-section h1 {
            font-size: 42px;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .features-title {
            font-size: 20px;
            font-weight: 600;
            margin: 30px 20px 20px;
            text-align: left;
        }
        
        .features-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 0 10px;
            margin: 0 10px;
            background-color: #fff;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            flex: 1;
            min-width: 250px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin: 0 10px 20px;
        }
        
        .icon-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f8f9fa;
            margin-right: 15px;
        }
        
        .icon-container i {
            color: #FF9800;
            font-size: 18px;
        }
        
        .icon-container.orange {
            background-color: #FF9800;
        }
        
        .icon-container.orange i {
            color: white;
        }
        
        .feature-text {
            flex: 1;
        }
        
        .feature-text h3 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }
        
        .feature-text p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            .features-section {
                flex-direction: column;
            }
            
            .feature-item {
                width: 100%;
                margin-bottom: 10px;
            }
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product-card {
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        
        .product-card h3 {
            margin: 10px 0;
            font-size: 16px;
        }
        
        .product-card p {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .rating {
            color: #ffd700;
            margin-top: 5px;
        }

        /* Discount Categories Section */
        .discount-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .discount-card {
            position: relative;
            height: 200px;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }

        .discount-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .discount-card:hover img {
            transform: scale(1.05);
        }

        .discount-card .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.7));
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 20px;
        }
        
        .discount-card h3 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Location Section */
        .location-section {
            padding: 20px;
            background: #f5f5f5;
            display: flex;
            flex-wrap: wrap;
        }
        
        .map {
            flex: 1;
            min-width: 300px;
        }
        
        .address {
            flex: 1;
            padding: 20px;
            min-width: 300px;
        }
        
        .address h3 {
            margin-top: 0;
            font-size: 20px;
        }
        
        .address p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
<div class="header-wrapper">
    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Lorem Ipsum</h1>
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
            <div class="icon-container orange">
                <i class="fas fa-arrow-right"></i>
            </div>
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
<section>
    <h1>Category</h1>
    <div class="discount-grid">
        <!-- Use categories as discount sections -->
        @foreach($categories as $category)
        <a href="" class="discount-card">
            <img src="{{ $category->gambar }}" alt="{{ $category->nama }}">
            <div class="overlay">
                <h3>{{ $category->nama }}</h3>
            </div>
        </a>
        @endforeach
    </div>
</section>

<!-- Favorite Products Section -->
    <section>
        <h1>Barang Favorit Kami</h1>
        <div class="products-grid">
            @foreach($products as $product)
            <a href="{{ route('products.show', $product->id) }}" class="product-card">
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_barang }}">
                <h3>{{ $product->nama_barang }}</h3>
                <p>{{ Str::limit($product->description, 50) }}</p>
                <div class="rating">
                    @php
                        $rating = $product->ratings->avg('rating') ?? 0;
                    @endphp
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $rating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                    ({{ $product->ratings->count() }})
                </div>
            </a>
            @endforeach
        </div>
    </section>


    <!-- Location Section -->
    <section class="location-section" id="Locate">
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
    </section>
</body>
</html>
@endsection