@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorasi UMKM</title>
</head>
<body>
<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Filter -->
        <header class="mb-8 p-6 bg-white rounded-xl shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Eksplorasi UMKM</h1>
                    <p class="text-gray-500 mt-1">Temukan produk terbaik dari seluruh penjuru.</p>
                </div>
                
                <!-- Form Filter -->
                <form action="{{ route('shop') }}" method="GET" class="w-full md:w-auto">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input type="text" name="search" class="w-full sm:w-48 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" placeholder="Cari produk..." value="{{ request('search') }}">
                        
                        <select name="province_id" id="provinceSelect" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Semua Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <select name="city_id" id="citySelect" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Semua Kota</option>
                            {{-- Opsi kota akan diisi oleh JavaScript --}}
                            @if(request('city_id') && $cities->where('id', request('city_id'))->first())
                                <option value="{{ request('city_id') }}" selected>{{ $cities->where('id', request('city_id'))->first()->name }}</option>
                            @endif
                        </select>
                        
                        <button type="submit" class="w-full sm:w-auto bg-orange-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-orange-600 transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            <span>Cari</span>
                        </button>
                    </div>
                </form>
            </div>
        </header>

        <!-- Product Grid -->
        <main>
            @if($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="bg-white rounded-xl shadow-md overflow-hidden group transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_barang }}" class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                            {{-- Opsi: Tambahkan overlay jika perlu --}}
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 truncate" title="{{ $product->nama_barang }}">{{ $product->nama_barang }}</h3>
                            
                            @php
                                $smallestSize = $product->sizes->sortBy('harga')->first();
                                $priceRange = $smallestSize ? 'Rp '. number_format($smallestSize->harga, 0, ',', '.') : 'Stok habis';
                            @endphp
                            <p class="text-lg font-bold text-orange-500 mt-1">{{ $priceRange }}</p>
                            
                            <div class="text-xs text-gray-500 mt-2 flex items-center gap-1 bg-gray-100 px-2 py-1 rounded-full w-fit">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $product->city->name ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-500 mt-3 pt-3 border-t">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="ml-1 font-semibold">{{ number_format($product->ratings->avg('rating') ?? 0, 1) }}</span>
                                <span class="mx-2">|</span>
                                <span>{{ $product->purchase_count ?? 0 }} terjual</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-10">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-20 px-6 bg-white rounded-lg shadow-md">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                    <p class="text-2xl font-semibold text-gray-700">Produk Tidak Ditemukan</p>
                    <p class="text-gray-500 mt-2">Coba ubah kata kunci pencarian atau filter lokasi Anda.</p>
                </div>
            @endif
        </main>
    </div>
</div>

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