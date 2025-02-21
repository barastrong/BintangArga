@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorasi UMKM</title>
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
            align-items: center;
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin: 0;
        }
        
        .search-container {
            display: flex;
            gap: 10px;
        }
        
        .search-input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 220px;
            font-size: 14px;
            color: #777;
        }
        
        .location-dropdown {
            background-color: #FFA500;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 14px;
            position: relative;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
            top: 100%;
            left: 0;
            margin-top: 5px;
        }
        
        .location-dropdown:hover .dropdown-content {
            display: block;
        }
        
        .dropdown-content a {
            color: black;
            padding: 10px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
        }
        
        .dropdown-content a:hover {
            background-color: #f1f1f1;
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
        }
        
        .product-card:hover {
            transform: translateY(-5px);
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
        
        .product-description {
            color: #777;
            font-size: 12px;
            margin: 0 0 8px 0;
            line-height: 1.4;
        }
        
        .rating {
            display: flex;
            align-items: center;
            margin-top: 8px;
        }
        
        .star {
            color: #FFA500;
            font-size: 14px;
        }
        
        .rating-value {
            margin-left: 4px;
            font-size: 12px;
            font-weight: bold;
            color: #555;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Explorasi UMKM</h1>
            
            <div class="search-container">
                <form action="{{ route('shop') }}" method="GET" style="display: flex; gap: 10px;">
                    <input type="text" name="search" class="search-input" placeholder="Cari..." value="{{ request('search') }}">
                </form>
                    
                <div class="location-dropdown" id="locationDropdown">
                    <span onclick="toggleDropdown()">Pilih Daerah <i id="dropdownArrow">&uarr;</i></span>
                    <div class="dropdown-content" id="locationOptions">
                        <a href="{{ route('shop') }}" class="location-option">Semua Daerah</a>
                        @php
                            $uniqueLocations = $products->pluck('lokasi')->unique();
                        @endphp
                        
                        @foreach($uniqueLocations as $location)
                            <a href="{{ route('shop', ['lokasi' => $location]) }}" class="location-option">{{ $location }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="product-grid">
            @foreach($products as $product)
            <div class="product-card">
                <div class="product-image">
                    <svg class="hanger-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L12 6M12 6C10.8954 6 10 6.89543 10 8C10 9.10457 10.8954 10 12 10M12 6C13.1046 6 14 6.89543 14 8C14 9.10457 13.1046 10 12 10M12 10L5 18H19L12 10Z"/>
                    </svg>
                    <img src="{{ Storage::url($product->sizes->first()->gambar_size) }}" alt="{{ $product->nama_barang }}">
                </div>
                <a href="{{ route('products.show', $product->id) }}" class="product-card">
                <div class="product-info">
                    <h3 class="product-title">{{ $product->nama_barang }}</h3>
                    <p class="product-description">{{ $product->description }}</p>
                    <div class="rating">
                        <span class="star">★</span>
                        <span class="rating-value">{{ number_format($product->ratings->avg('rating') ?? 0, 1) }}</span>
                    </div>
                </div>
            </a>
            </div>
            @endforeach
        </div>  
        
        <div class="pagination">
            @if($products->onFirstPage())
                <span style="color: #aaa;">Prev</span>
            @else
                <a href="{{ $products->previousPageUrl() }}">Prev</a>
            @endif
            
            <span>{{ $products->currentPage() }}</span>
            
            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}">Next</a>
            @else
                <span style="color: #aaa;">Next</span>
            @endif
        </div>
    </div>

    <script>
function toggleDropdown() {
    const content = document.getElementById("locationOptions");
    const arrow = document.getElementById("dropdownArrow");
    
    if (content.style.display === "block") {
        content.style.display = "none";
        arrow.innerHTML = "&uarr;";
    } else {
        content.style.display = "block";
        arrow.innerHTML = "&darr;";
    }
}

// Don't close dropdown when clicking inside it
document.getElementById("locationOptions").addEventListener("click", function(e) {
    e.stopPropagation();
});

function filterLocations() {
    const input = document.getElementById("locationSearch");
    const filter = input.value.toUpperCase();
    const options = document.getElementsByClassName("location-option");
    
    for (let i = 0; i < options.length; i++) {
        const txtValue = options[i].textContent || options[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            options[i].style.display = "";
        } else {
            options[i].style.display = "none";
        }
    }
}

// Close dropdown when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.location-dropdown span') && !event.target.matches('#dropdownArrow')) {
        document.getElementById("locationOptions").style.display = "none";
        document.getElementById("dropdownArrow").innerHTML = "&uarr;";
    }
}
    </script>
</body>
</html>
@endsection