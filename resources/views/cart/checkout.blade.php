@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>

        <form id="checkout-form" action="{{ route('cart.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- Kolom Kiri: Detail Pesanan & Pengiriman -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Daftar Item -->
                    <div class="bg-white rounded-xl shadow-md">
                        <h2 class="text-xl font-semibold text-gray-800 p-6 border-b">Barang Pesanan</h2>
                        <div class="p-6 space-y-4">
                            @foreach($selectedItems as $item)
                                <div class="flex gap-4" id="item-{{ $item->id }}">
                                    <img src="{{ Storage::url($item->size->gambar_size) }}" alt="{{ $item->product->nama_barang }}" class="w-24 h-24 rounded-lg object-cover">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800">{{ $item->product->nama_barang }}</h3>
                                        <p class="text-sm text-gray-500">Ukuran: {{ $item->size->size }}</p>
                                        <p class="text-sm text-gray-500">Jumlah: {{ $item->quantity }}</p>
                                        <p class="font-semibold text-gray-700 mt-1">Rp {{ number_format($item->size->harga, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="font-bold text-lg text-gray-800">Rp {{ number_format($item->size->harga * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                                {{-- Input tersembunyi untuk setiap item --}}
                                <input type="hidden" name="cart_items[]" value="{{ $item->id }}">
                                <input type="hidden" name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}">
                            @endforeach
                        </div>
                    </div>

                    <!-- Detail Pengiriman -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Pengiriman</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                                <textarea name="shipping_address" id="shipping_address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required></textarea>
                            </div>
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="tel" name="phone_number" id="phone_number" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required>
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Catatan Pembelian (opsional)</label>
                                <textarea name="description" id="description" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan: Ringkasan & Pembayaran -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-24 space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800">Ringkasan Pesanan</h2>
                        
                        <!-- Rincian Harga -->
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pajak (10%)</span>
                                <span class="font-medium">Rp {{ number_format($totalPrice * 0.1, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Layanan</span>
                                <span class="font-medium">Rp {{ number_format($totalPrice * 0.03, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Total Akhir -->
                        <div class="flex justify-between items-center border-t pt-4">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            @php
                                $finalTotal = $totalPrice + ($totalPrice * 0.1) + ($totalPrice * 0.03);
                            @endphp
                            <span class="text-xl font-bold text-orange-600">Rp {{ number_format($finalTotal, 0, ',', '.') }}</span>
                            <input type="hidden" name="total_with_tax" value="{{ $finalTotal }}">
                        </div>

                        <!-- Metode Pembayaran -->
                        <div>
                            <label class="block text-base font-semibold text-gray-700 mb-3">Metode Pembayaran</label>
                            <div class="space-y-3">
                                <label for="payment_gopay" class="flex items-center p-3 border rounded-lg cursor-pointer hover:border-orange-500 transition has-[:checked]:bg-orange-50 has-[:checked]:border-orange-500">
                                    <input type="radio" name="payment_method" value="gopay" id="payment_gopay" class="h-4 w-4 text-orange-600 border-gray-300 focus:ring-orange-500">
                                    <span class="ml-3 font-medium text-sm text-gray-700">Gopay</span>
                                </label>
                                <label for="payment_qris" class="flex items-center p-3 border rounded-lg cursor-pointer hover:border-orange-500 transition has-[:checked]:bg-orange-50 has-[:checked]:border-orange-500">
                                    <input type="radio" name="payment_method" value="qris" id="payment_qris" class="h-4 w-4 text-orange-600 border-gray-300 focus:ring-orange-500">
                                    <span class="ml-3 font-medium text-sm text-gray-700">QRIS</span>
                                </label>
                                <label for="payment_nyicil" class="flex items-center p-3 border rounded-lg cursor-pointer hover:border-orange-500 transition has-[:checked]:bg-orange-50 has-[:checked]:border-orange-500">
                                    <input type="radio" name="payment_method" value="nyicil" id="payment_nyicil" class="h-4 w-4 text-orange-600 border-gray-300 focus:ring-orange-500">
                                    <span class="ml-3 font-medium text-sm text-gray-700">Nyicil</span>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="w-full bg-orange-500 text-white font-bold py-3 px-6 rounded-lg text-center hover:bg-orange-600 transition-transform hover:scale-105">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Tidak perlu JavaScript kompleks lagi karena kuantitas sudah final --}}

@endsection