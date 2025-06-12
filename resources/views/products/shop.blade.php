@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorasi UMKM</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-container {
                flex-direction: column;
                gap: 10px;
            }
            
            .search-input, .filter-select {
                width: 100%;
                min-width: auto;
            }
        }
        
        .page-title {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin: 0;
        }
        
        .search-container {
            display: flex;
            gap: 15px;
            align-items: center;
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
        }
        
        .search-input {
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            width: 250px;
            font-size: 14px;
            color: #495057;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }
        
        .search-input::placeholder {
            color: #adb5bd;
        }
        
        .filter-select {
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            color: #495057;
            background-color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 150px;
        }
        
        .filter-select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }
        
        .filter-select:hover {
            border-color: #007bff;
        }
        
        .filter-btn {
            background: linear-gradient(135deg, #FFA500, #FF8C00);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(255, 165, 0, 0.3);
        }
        
        .filter-btn:hover {
            background: linear-gradient(135deg, #FF8C00, #FF7F00);
            box-shadow: 0 4px 8px rgba(255, 165, 0, 0.4);
            transform: translateY(-1px);
        }
        
        .filter-btn:active {
            transform: translateY(0);
        }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        
        .product-card {
            background-color: white;
            box-shadow: 1px 1px 2px gray;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s;
            text-decoration: none;
            color: inherit;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            text-decoration: none;
            color: inherit;
        }
        
        .product-image {
            height: 200px;
            overflow: hidden;
            position: relative;
            background-color: #eee;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .hanger-icon {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 35px;
            height: 35px;
            color: #777;
        }
        
        .product-info {
            padding: 12px;
        }
        
        .product-title {
            font-weight: bold;
            margin: 0 0 8px 0;
            font-size: 16px;
        }
        
        .product-price {
            font-weight: bold;
            color: #FF9800;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .rating {
            color: #ffd700;
            margin-top: 5px;
        }
        
        .rating-value {
            margin-left: 4px;
            font-size: 12px;
            font-weight: bold;
            color: #555;
        }
        
        .location-info {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #666;
            font-size: 12px;
            margin: 5px 0;
            background-color: #f8f9fa;
            padding: 4px 8px;
            border-radius: 12px;
            border: 1px solid #e9ecef;
        }
        
        .location-info i {
            font-size: 10px;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            align-items: center;
        }
        
        .pagination a, .pagination span {
            padding: 8px 12px;
            margin: 0 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            background-color: white;
            transition: background-color 0.2s;
        }
        
        .pagination a:hover {
            background-color: #f5f5f5;
        }
        
        .pagination span {
            background-color: white;
        }
        
        .seller-info {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
            margin: 8px 0;
        }

        .seller-info i {
            color: #666;
        }

        /* Particle background styles */
        .particle-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }
        
        #particleCanvas {
            width: 100%;
            height: 100%;
            display: block;
        }
    </style>
</head>
<body>
    <div class="particle-background">
        <canvas id="particleCanvas"></canvas>
    </div>
    
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Explorasi UMKM</h1>
            
            <div class="search-container">
                <form action="{{ route('shop') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" name="search" class="search-input" placeholder="Cari produk..." value="{{ request('search') }}">
                    
                    <select name="province_id" class="filter-select" id="provinceSelect">
                        <option value="">Semua Provinsi</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select name="city_id" class="filter-select" id="citySelect">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>
            </div>
        </div>
        
        @if($products->count() > 0)
            <div class="product-grid">
                @foreach($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="product-card">
                    <div class="product-image">
                        <i class="fas fa-hanger hanger-icon"></i>
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_barang }}">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">{{ $product->nama_barang }}</h3>
                        
                        @php
                            $smallestSize = $product->sizes->sortBy('harga')->first();
                            $priceRange = $smallestSize ? 'Rp '. number_format($smallestSize->harga, 0, ',', '.') : 'Harga tidak tersedia';
                        @endphp
                        <div class="product-price">{{ $priceRange }}</div>
                        
                        <div class="location-info">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $product->city->name ?? 'Kota tidak diketahui' }}, {{ $product->province->name ?? 'Provinsi tidak diketahui' }}</span>
                        </div>
                        
                        <div class="rating">
                            <i class="fas fa-star"></i>    
                            {{ number_format($product->ratings->avg('rating') ?? 0, 1) }} |
                            <span style="color: #666; margin-left: 5px;">
                                <i class="fas fa-shopping-cart"></i> {{ $product->purchase_count ?? 0 }} terjual
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 50px; color: #666;">
                <i class="fas fa-search" style="font-size: 48px; margin-bottom: 20px;"></i>
                <h3>Tidak ada produk ditemukan</h3>
                <p>Coba ubah kata kunci pencarian atau filter lokasi Anda.</p>
            </div>
        @endif
        
        @if($products->hasPages())
        <div class="pagination">
            @if($products->onFirstPage())
                <span style="color: #aaa;">Prev</span>
            @else
                <a href="{{ $products->appends(request()->query())->previousPageUrl() }}">Prev</a>
            @endif
            
            <span>{{ $products->currentPage() }} dari {{ $products->lastPage() }}</span>
            
            @if($products->hasMorePages())
                <a href="{{ $products->appends(request()->query())->nextPageUrl() }}">Next</a>
            @else
                <span style="color: #aaa;">Next</span>
            @endif
        </div>
        @endif
    </div>

    <script src="/js/particles.js"></script>
    <script>
        // Handle province change to load cities
        document.getElementById('provinceSelect').addEventListener('change', function() {
            const provinceId = this.value;
            const citySelect = document.getElementById('citySelect');
            
            // Clear city options
            citySelect.innerHTML = '<option value="">Semua Kota</option>';
            
            if (provinceId) {
                // Fetch cities for the selected province
                fetch(`/api/cities/${provinceId}`)
                    .then(response => response.json())
                    .then(cities => {
                        cities.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching cities:', error);
                    });
            }
        });
    </script>
</body>
</html>
@endsection