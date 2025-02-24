<!-- resources/views/cart/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <div class="bg-gray-50 rounded-lg p-8 text-center">
            <p class="text-gray-600 mb-4">Your cart is empty</p>
            <a href="{{ route('products.index') }}" class="bg-yellow-500 text-white px-6 py-2 rounded-lg inline-block hover:bg-yellow-600 transition">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-lg shadow-sm mb-4 p-4">
                        <div class="flex items-center">
                            <img src="{{ Storage::url($item->product->sizes->first()->gambar_size) }}" 
                                 alt="{{ $item->product->nama_barang }}" 
                                 class="w-24 h-24 object-cover rounded-lg">
                            
                            <div class="ml-4 flex-grow">
                                <h3 class="font-semibold">{{ $item->product->nama_barang }}</h3>
                                <p class="text-gray-600">Size: {{ $item->size->size }}</p>
                                <p class="text-gray-600">Rp {{ number_format($item->size->harga, 0, ',', '.') }}</p>
                                
                                <div class="flex items-center mt-2">
                                    <div class="flex items-center border rounded">
                                        <button onclick="updateQuantity({{ $item->id }}, -1)" 
                                                class="px-3 py-1 border-r hover:bg-gray-100">-</button>
                                        <input type="number" value="{{ $item->quantity }}" 
                                               class="w-16 text-center px-2 py-1 focus:outline-none" 
                                               readonly>
                                        <button onclick="updateQuantity({{ $item->id }}, 1)" 
                                                class="px-3 py-1 border-l hover:bg-gray-100">+</button>
                                    </div>
                                    
                                    <form action="{{ route('cart.remove', $item) }}" method="POST" class="ml-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($cartItems->sum(function($item) {
                                return $item->quantity * $item->size->harga;
                            }), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('purchases.index') }}" 
                           class="w-full bg-yellow-500 text-white px-6 py-3 rounded-lg inline-block text-center hover:bg-yellow-600 transition">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function updateQuantity(cartId, delta) {
    const quantityInput = event.target.parentNode.querySelector('input');
    const currentQty = parseInt(quantityInput.value);
    const newQty = currentQty + delta;
    
    if (newQty >= 1) {
        fetch(`/cart/${cartId}/update`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                quantity: newQty
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error updating quantity');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating quantity');
        });
    }
}
</script>
@endsection