@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Buat Pesanan</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('purchases.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="size_id" value="{{ $size->id }}">

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity">
                    Jumlah
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="quantity" 
                    type="number" 
                    name="quantity" 
                    value="{{ old('quantity', 1) }}" 
                    min="1">
                @error('quantity')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="shipping_address">
                    Alamat Pengiriman
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="shipping_address" 
                    name="shipping_address" 
                    rows="3">{{ old('shipping_address') }}</textarea>
                @error('shipping_address')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone_number">
                    Nomor Telepon
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="phone_number" 
                    type="text" 
                    name="phone_number" 
                    value="{{ old('phone_number') }}">
                @error('phone_number')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                    type="submit">
                    Buat Pesanan
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" 
                    href="{{ route('products.show', $product) }}">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection