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
    <h1 class="text-2xl font-bold mb-8">KERANJANG</h1>

    @if($cartItems->isEmpty())
        <div class="bg-gray-50 rounded-lg p-8 text-center">
            <p class="text-gray-600 mb-4">Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="bg-yellow-500 text-white px-6 py-2 rounded-lg inline-block hover:bg-yellow-600 transition">
                Continue Shopping
            </a>
        </div>
    @else
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded border p-4 relative">
                        <div class="absolute top-2 left-2">
                            <input type="checkbox" name="cart_items[]" value="{{ $item->id }}" class="w-5 h-5">
                        </div>
                        
                        <div class="flex flex-col items-center text-center">
                            <img src="{{ Storage::url($item->product->sizes->first()->gambar_size) }}" 
                                 alt="{{ $item->product->nama_barang }}" 
                                 class="w-32 h-40 object-cover mb-2">
                            
                            <h3 class="font-semibold text-sm">{{ $item->product->nama_barang }}</h3>
                            <p class="text-gray-600 text-xs">Ukuran: {{ $item->size->size }}</p>
                            <p class="text-gray-600 text-xs">Jumlah: {{ $item->quantity }}</p>
                            
                            <p class="text-gray-800 text-sm">
                                Rp {{ number_format($item->size->harga, 0, ',', '.') }}
                            </p>
                            
                            <button type="submit" class="mt-2 px-4 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600 transition">
                                Checkout
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8 text-center">
                <button type="submit" class="px-8 py-3 bg-yellow-500 text-white text-lg font-semibold rounded hover:bg-yellow-600 transition">
                    Checkout
                </button>
            </div>
            
            <div class="mt-6 flex justify-center">
                <nav class="inline-flex">
                    <a href="#" class="px-3 py-1 bg-gray-200 text-gray-700 border border-r-0 rounded-l">
                        Prev
                    </a>
                    <a href="#" class="px-3 py-1 bg-white text-gray-700 border">
                        1
                    </a>
                    <a href="#" class="px-3 py-1 bg-gray-200 text-gray-700 border border-l-0 rounded-r">
                        Next
                    </a>
                </nav>
            </div>
        </form>
    @endif
</div>
</body>
</html>
@endsection