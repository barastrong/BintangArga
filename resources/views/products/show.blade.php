@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Kembali ke explore
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Main Product Image -->
        <div class="relative">
            @if($product->sizes->isNotEmpty())
                <img id="mainImage" src="{{ Storage::url($product->sizes->first()->gambar_size) }}" 
                     alt="{{ $product->nama_barang }}" 
                     class="w-full rounded-lg shadow-lg object-cover max-h-96">
                
                <!-- Thumbnail Images -->
                <div class="grid grid-cols-4 gap-2 mt-4">
                    @foreach($product->sizes as $size)
                        <img src="{{ Storage::url($size->gambar_size) }}" 
                             alt="{{ $product->nama_barang }} - {{ $size->size }}"
                             onclick="updateMainImage('{{ Storage::url($size->gambar_size) }}')"
                             class="w-full h-20 object-cover rounded-lg cursor-pointer shadow hover:opacity-75 transition">
                    @endforeach
                </div>
            @else
                <div class="bg-gray-200 w-full h-96 flex items-center justify-center rounded-lg">
                    <p class="text-gray-500">No image available</p>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ $product->nama_barang }}</h1>
            
            <!-- Rating -->
            <div class="flex items-center mb-4">
                <div class="flex text-yellow-400">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($averageRating))
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        @endif
                    @endfor
                </div>
                <span class="ml-2 text-gray-700">{{ number_format($averageRating, 1) }} ({{ $product->purchases->count() }} reviews)</span>
            </div>

            <!-- Description -->
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <h2 class="font-semibold text-lg mb-2">Description</h2>
                <p class="text-gray-700">{{ $product->description }}</p>
            </div>

            <!-- Size Chart -->
            <div class="mb-6">
                <h2 class="font-semibold text-lg mb-4">SIZE CHART</h2>
                
                @foreach($product->sizes as $size)
                <div class="flex items-center justify-between mb-4 border-b pb-4">
                    <div class="flex items-center">
                        <img src="{{ Storage::url($size->gambar_size) }}" 
                             alt="{{ $size->size }}" 
                             class="w-16 h-16 object-cover rounded-lg shadow">
                        <div class="ml-4">
                            <h3 class="font-bold">{{ $size->size }}</h3>
                            <p class="text-gray-700 font-semibold">Rp {{ number_format($size->harga, 0, ',', '.') }}</p>
                            <p class="text-sm {{ $size->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $size->stock > 0 ? 'Stock: ' . $size->stock : 'Out of Stock' }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Add to Cart Button -->
                    @if($size->stock > 0)
                        <a href="{{ route('purchases.create', ['product' => $product->id, 'size' => $size->id]) }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg inline-block transition shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Beli
                        </a>
                    @else
                        <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed">
                            Out of Stock
                        </button>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">Customer Reviews</h2>
        
        @if($product->purchases->where('rating', '!=', null)->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($product->purchases->where('rating', '!=', null)->take(4) as $purchase)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold">{{ $purchase->user->name ?? 'Anonymous' }}</p>
                                <div class="flex text-yellow-400 mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $purchase->rating)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $purchase->updated_at->diffForHumans() }}</span>
                        </div>
                        
                        @if($purchase->review)
                            <p class="text-gray-700 mt-2">{{ $purchase->review }}</p>
                        @else
                            <p class="text-gray-500 italic mt-2">No written review</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-50 p-6 rounded-lg text-center">
                <p class="text-gray-600">No reviews yet. Be the first to leave a review!</p>
            </div>
        @endif
    </div>
</div>

<script>
    function updateMainImage(imageUrl) {
        document.getElementById('mainImage').src = imageUrl;
    }
</script>
@endsection