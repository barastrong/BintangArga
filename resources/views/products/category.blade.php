@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Header Halaman -->
        <div class="mb-10">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800 transition-colors mb-4">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Halaman Utama</span>
            </a>
            <h1 class="text-4xl font-bold text-gray-800 tracking-tight border-b-4 border-orange-500 pb-4">
                {{ $category->nama }}
            </h1>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-20 px-6 bg-gray-50 rounded-lg">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <p class="text-2xl font-semibold text-gray-700">Belum Ada Produk</p>
                <p class="text-gray-500 mt-2">Tidak ada produk yang ditemukan dalam kategori ini.</p>
            </div>
        @else
            <!-- Grid Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="block group rounded-xl overflow-hidden shadow-lg hover:shadow-2xl border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="relative overflow-hidden">
                        {{-- Ikon Hanger --}}
                        <svg class="absolute top-3 right-3 w-7 h-7 text-orange-500 z-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L12 6M12 6C10.8954 6 10 6.89543 10 8C10 9.10457 10.8954 10 12 10M12 6C13.1046 6 14 6.89543 14 8C14 9.10457 13.1046 10 12 10M12 10L5 18H19L12 10Z"/>
                        </svg>
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_barang }}" 
                             class="h-64 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800 truncate" title="{{ $product->nama_barang }}">{{ $product->nama_barang }}</h3>
                        @php
                            $smallestSize = $product->sizes->sortBy('harga')->first();
                            $priceRange = $smallestSize ? 'Rp '. number_format($smallestSize->harga, 0, ',', '.') : 'Harga tidak tersedia';
                        @endphp
                        <p class="text-base font-bold text-orange-600 mt-1">{{ $priceRange }}</p>
                        <div class="flex items-center text-sm text-gray-500 mt-2 pt-2 border-t">
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
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection