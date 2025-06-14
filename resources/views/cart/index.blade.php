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
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Keranjang Belanja</h1>

        @if($cartItems->isEmpty())
            <div class="text-center py-20 px-6 bg-white rounded-lg shadow-md">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                <p class="text-2xl font-semibold text-gray-700">Keranjangmu masih kosong</p>
                <p class="text-gray-500 mt-2">Ayo jelajahi toko dan temukan barang favoritmu!</p>
                <a href="{{ route('shop') }}" class="mt-6 inline-block bg-orange-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-orange-600 transition-colors">
                    Mulai Belanja
                </a>
            </div>
        @else
            <form id="cartForm" action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <div class="bg-white rounded-xl shadow-md">
                    <div class="p-4 border-b flex justify-between items-center">
                        <label for="selectAll" class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" id="selectAll" class="h-5 w-5 rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                            <span class="font-semibold text-gray-700">Pilih Semua</span>
                        </label>
                    </div>
                    
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                            <li class="p-4 sm:p-6 flex items-start space-x-4">
                                <input type="checkbox" name="cart_items[]" value="{{ $item->id }}" class="h-5 w-5 rounded border-gray-300 text-orange-600 focus:ring-orange-500 mt-1 flex-shrink-0 cart-item-checkbox">
                                
                                <img src="{{ Storage::url($item->size->gambar_size) }}" alt="{{ $item->product->nama_barang }}" class="w-20 h-24 sm:w-24 sm:h-28 rounded-lg object-cover">
                                
                                <div class="flex-1">
                                    <a href="{{ route('products.show', $item->product->id) }}" class="font-semibold text-gray-800 hover:text-orange-600 leading-tight">{{ $item->product->nama_barang }}</a>
                                    <p class="text-sm text-gray-500 mt-1">Ukuran: {{ $item->size->size }}</p>
                                    <p class="text-lg font-bold text-orange-500 mt-2">Rp {{ number_format($item->size->harga, 0, ',', '.') }}</p>
                                </div>
                                
                                <div class="flex flex-col items-center space-y-2">
                                    {{-- INI BAGIAN YANG DIPERBAIKI DENGAN TELITI --}}
                                    <div class="text-center">
                                        <p class="text-sm text-gray-500">Jumlah</p>
                                        {{-- Menggunakan 'quantity' sesuai dengan properti di model/database --}}
                                        <p class="font-semibold">{{ $item->quantity }}</p>
                                    </div>
                                    <a href="#" onclick="event.preventDefault(); if(confirm('Hapus item ini dari keranjang?')) document.getElementById('delete-form-{{ $item->id }}').submit();" class="text-xs text-gray-400 hover:text-red-500 font-medium flex items-center gap-1">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-8 text-right">
                    <button type="submit" id="checkoutBtn" class="bg-orange-500 text-white font-semibold py-3 px-8 rounded-lg hover:bg-orange-600 transition-colors disabled:bg-gray-300 disabled:cursor-not-allowed">
                        Checkout
                    </button>
                </div>
            </form>

            <div class="hidden">
                @foreach($cartItems as $item)
                    <form id="delete-form-{{ $item->id }}" action="{{ route('cart.remove', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            </div>
        @endif
    </div>
</div>
<!-- JavaScript untuk menangani checkout -->
<script>
// Kode JavaScript sederhana yang sudah terbukti
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.cart-item-checkbox');
    const checkoutBtn = document.getElementById('checkoutBtn');

    function toggleCheckoutButton() {
        const checkedCount = document.querySelectorAll('.cart-item-checkbox:checked').length;
        checkoutBtn.disabled = checkedCount === 0;
    }

    selectAllCheckbox.addEventListener('change', function() {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleCheckoutButton();
    });

    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const allChecked = itemCheckboxes.length > 0 && Array.from(itemCheckboxes).every(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
            toggleCheckoutButton();
        });
    });

    toggleCheckoutButton();
});
</script>

@if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
    <script>
        setTimeout(function() {
            const successAlert = document.querySelector('.fixed.top-4.bg-green-500');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
        }, 3000);
    </script>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
    <script>
        setTimeout(function() {
            const errorAlert = document.querySelector('.fixed.top-4.bg-red-500');
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 3000);
    </script>
@endif

</body>
</html>
@endsection