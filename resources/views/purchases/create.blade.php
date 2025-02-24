@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Buat Pesanan</h1>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Product Details Card -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex items-center">
                <!-- Product Image -->
                <div class="w-32 h-32 flex-shrink-0">
                    <img src="{{ Storage::url($product->gambar) }}" 
                         alt="{{ $product->nama_barang }}"
                         class="w-full h-full object-cover rounded-lg">
                </div>
                
                <!-- Product and User Info -->
                <div class="ml-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $product->nama_barang }}</h2>
                    <p class="text-gray-600">Penjual: {{ $product->user->name }}</p>
                    @if($size)
                    <p class="text-gray-600 mt-2">Stock: {{ $size->stock }}</p>
                        <p class="text-gray-600 mt-2">Ukuran: {{ $size->size }}</p>
                        <p class="text-gray-800 font-semibold">Harga: Rp {{ number_format($size->harga, 0, ',', '.') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="size_id" value="{{ $size->id }}">

                <!-- Quantity Input -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">
                        Jumlah
                    </label>
                    <input class="shadow-sm border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        id="quantity" 
                        type="number" 
                        name="quantity" 
                        value="{{ old('quantity', 1) }}" 
                        min="1"
                        max="{{ $size->stock ?? 999 }}">
                    @error('quantity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Shipping Address -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="shipping_address">
                        Alamat Pengiriman
                    </label>
                    <textarea class="shadow-sm border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        id="shipping_address" 
                        name="shipping_address" 
                        rows="3"
                        placeholder="Masukkan alamat lengkap pengiriman">{{ old('shipping_address') }}</textarea>
                    @error('shipping_address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="phone_number">
                        Nomor Telepon
                    </label>
                    <input class="shadow-sm border border-gray-300 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        id="phone_number" 
                        type="tel" 
                        name="phone_number" 
                        value="{{ old('phone_number') }}"
                        placeholder="Contoh: 08123456789">
                    @error('phone_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors" 
                        type="submit">
                        Buat Pesanan
                    </button>
                    <a class="text-blue-500 hover:text-blue-600 font-semibold" 
                        href="{{ route('products.show', $product) }}">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
@endsection