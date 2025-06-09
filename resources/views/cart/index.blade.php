@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        <!-- Grid untuk menampilkan items -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($cartItems as $item)
                <div class="bg-white rounded border p-4 relative">
                    <!-- Checkbox untuk checkout -->
                    <div class="absolute top-2 left-2">
                        <input type="checkbox" name="cart_items[]" value="{{ $item->id }}" class="w-5 h-5 checkout-checkbox">
                    </div>
                    
                    <!-- Remove Button - Form terpisah -->
                    <div class="absolute top-2 right-2">
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full p-1 transition-colors duration-200">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </form>
                    </div>
                    
                    <div class="flex flex-col items-center text-center mt-6">
                        <img src="{{ Storage::url($item->size->gambar_size) }}" 
                            alt="{{ $item->product->nama_barang }} - {{ $item->size->size }}" 
                            class="w-32 h-40 object-cover mb-2">
                        
                        <h3 class="font-semibold text-sm">{{ $item->product->nama_barang }}</h3>
                        <p class="text-gray-600 text-xs">Ukuran: {{ $item->size->size }}</p>
                        <p class="text-gray-600 text-xs">Jumlah: {{ $item->quantity }}</p>
                        
                        <p class="text-gray-800 text-sm font-semibold">
                            Rp {{ number_format($item->size->harga, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Form Checkout terpisah -->
        <form id="checkoutForm" action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <!-- Hidden inputs akan ditambahkan via JavaScript -->
            <div class="mt-8 text-center">
                <button type="submit" class="px-8 py-3 bg-yellow-500 text-white text-lg font-semibold rounded hover:bg-yellow-600 transition">
                    Checkout Selected Items
                </button>
            </div>
        </form>
        
        <!-- Pagination -->
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
    @endif
</div>

<!-- JavaScript untuk menangani checkout -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkoutForm = document.getElementById('checkoutForm');
    const checkboxes = document.querySelectorAll('.checkout-checkbox');
    
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            // Hapus semua hidden input sebelumnya
            const existingInputs = checkoutForm.querySelectorAll('input[name="cart_items[]"]');
            existingInputs.forEach(input => input.remove());
            
            // Tambahkan hidden input untuk setiap checkbox yang dicentang
            const checkedBoxes = document.querySelectorAll('.checkout-checkbox:checked');
            
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu item untuk checkout');
                return false;
            }
            
            checkedBoxes.forEach(checkbox => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'cart_items[]';
                hiddenInput.value = checkbox.value;
                checkoutForm.appendChild(hiddenInput);
            });
        });
    }
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