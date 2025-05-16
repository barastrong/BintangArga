@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->nama }} - Products</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-orange: #FF6B35;
            --light-gray: #F8F9FA;
            --dark-gray: #333333;
            --soft-shadow: 0 6px 12px rgba(0,0,0,0.08);
        }
        body {
            background-color: #ffffff;
            font-family: 'Inter', 'Arial', sans-serif;
            color: var(--dark-gray);
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .category-title {
            font-weight: 700;
            font-size: 2.5rem;
            color: var(--dark-gray);
            border-bottom: 4px solid var(--primary-orange);
            padding-bottom: 15px;
            margin-bottom: 40px;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }
        .product-card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: var(--soft-shadow);
            text-decoration: none;
            color: inherit;
            display: block;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 20px rgba(0,0,0,0.1);
        }
        .product-image {
            position: relative;
            overflow: hidden;
        }
        .hanger-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            color: var(--primary-orange);
            z-index: 10;
        }
        .product-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .product-card:hover img {
            transform: scale(1.05);
        }
        .product-info {
            padding: 1rem;
            background-color: var(--light-gray);
        }
        .product-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-gray);
        }
        .product-price {
            font-weight: bold;
            color: #FF9800;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .seller-info {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            color: #666;
        }
        .seller-info i {
            margin-right: 0.5rem;
        }
        .rating {
            color: #ffd700;
            margin-top: 5px;
        }
        .rating .star {
            margin-right: 0.3rem;
        }
        .category-pagination {
            margin-top: 2rem;
        }
        .category-pagination .page-link {
            color: var(--primary-orange);
            border-color: var(--primary-orange);
        }
        .category-pagination .page-item.active .page-link {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
        }
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
<div class="mb-4">
        <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Kembali ke explore
        </a>
    </div>
    <h1 class="category-title">{{ $category->nama }}</h1>

    <!-- Products Grid -->
    <div class="product-grid">
        @foreach($products as $product)
        <a href="{{ route('products.show', $product->id) }}" class="product-card">
            <div class="product-image">
                <svg class="hanger-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L12 6M12 6C10.8954 6 10 6.89543 10 8C10 9.10457 10.8954 10 12 10M12 6C13.1046 6 14 6.89543 14 8C14 9.10457 13.1046 10 12 10M12 10L5 18H19L12 10Z"/>
                </svg>
                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_barang }}">
            </div>
            <div class="product-info">
                <h3 class="product-title">{{ $product->nama_barang }}</h3>
                @php
                    $smallestSize = $product->sizes->sortBy('harga')->first();
                    $priceRange = 'Rp '. number_format($smallestSize->harga, 0, ',', '.');
                @endphp
                <div class="product-price">{{ $priceRange }}</div>
                <!-- <div class="seller-info">
                    <i class="fas fa-user"></i>
                    <span>{{ $product->seller->nama_penjual }}</span>
                </div> -->
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
        @if($products->isEmpty())
    <div class="col-12">
        <p class="alert alert-info">No products found in this category.</p>
    </div>
    @endif
    </div>        

    <!-- Pagination -->
    <div class="d-flex justify-content-center category-pagination">
        {{ $products->links() }}
    </div>
</div>
</body>
</html>
@endsection