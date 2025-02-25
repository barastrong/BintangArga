@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
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
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-2">{{ $product->nama_barang }}</h1>
        <div class="flex items-center">
            <span class="bg-blue-500 rounded-full p-2 mr-3">
                <i class="fas fa-user-circle"></i>
            </span>
            <div>
                <span class="text-gray-500 text-sm">Penjual</span>
                <p class="font-semibold">{{ $product->user->name }}</p>
            </div>
        </div>
    </div>
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
                    <button onclick="openPurchaseModal('{{ $size->id }}', '{{ $size->size }}', {{ $size->harga }}, {{ $size->stock }}, '{{ $product->id }}')" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg inline-block transition shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Beli
                    </button>
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

    <!-- Add this Purchase Modal at the end of the container div -->
    <div id="purchaseModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="border-b px-6 py-4 sticky top-0 bg-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900">Detail Pembelian</h3>
                        </div>
                        <button onclick="closePurchaseModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form id="purchaseForm" method="POST" action="{{ route('purchases.store') }}" class="px-6 py-4">
                    @csrf
                    <input type="hidden" name="product_id" id="productId">
                    <input type="hidden" name="size_id" id="sizeId">
                    
                    <!-- Product Details -->
                    <div class="mb-6">
                        <h4 class="font-semibold mb-2">{{ $product->nama_barang }}</h4>
                        <p class="text-gray-600">Size: <span id="selectedSize"></span></p>
                        <p class="text-gray-600">Harga: Rp <span id="selectedPrice"></span></p>
                    </div>

                    <!-- Quantity Selection -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Jumlah</label>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center border rounded">
                                <button type="button" onclick="updateQuantity(-1)" class="px-3 py-1 border-r hover:bg-gray-100">-</button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" 
                                       class="w-16 text-center px-2 py-1 focus:outline-none" readonly>
                                <button type="button" onclick="updateQuantity(1)" class="px-3 py-1 border-l hover:bg-gray-100">+</button>
                            </div>
                            <span class="text-gray-500">Stock: <span id="availableStock">0</span></span>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="mb-6">
                        <label for="shipping_address" class="block text-gray-700 font-medium mb-2">Alamat Pengiriman</label>
                        <textarea name="shipping_address" id="shipping_address" rows="3" 
                                  class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                  required></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="phone_number" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                        <input type="tel" name="phone_number" id="phone_number" 
                               class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                               required>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Catatan Pembelian</label>
                        <textarea name="description" id="description" rows="2" 
                                  class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                  required></textarea>
                    </div>

                    <!-- Total Price -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="flex justify-between font-semibold">
                            <span>Total Pembayaran:</span>
                            <span>Rp <span id="subtotal">0</span></span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex space-x-4">
                    @if($size->stock > 0)
                    <button type="button" onclick="addToCart()" 
                        class="flex-1 bg-white border-2 border-yellow-500 text-yellow-500 hover:bg-yellow-50 px-4 py-2 rounded-lg transition shadow flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Keranjang
                    </button>
                    
                    <button type="submit" 
                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition shadow flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Beli Sekarang
                    </button>
                        @else
                        <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed">
                            Out of Stock
                        </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    function updateMainImage(imageUrl) {
        document.getElementById('mainImage').src = imageUrl;
    }

    let currentSizeId = null;
    let currentStock = 0;
    let currentPrice = 0;

    function openPurchaseModal(sizeId, sizeName, price, stock, productId) {
        currentSizeId = sizeId;
        currentStock = stock;
        currentPrice = price;
        
        document.getElementById('sizeId').value = sizeId;
        document.getElementById('productId').value = productId;
        document.getElementById('selectedSize').textContent = sizeName;
        document.getElementById('selectedPrice').textContent = formatPrice(price);
        document.getElementById('availableStock').textContent = stock;
        document.getElementById('quantity').value = 1;
        updateSubtotal();
        
        document.getElementById('purchaseModal').classList.remove('hidden');
    }

    function closePurchaseModal() {
        document.getElementById('purchaseModal').classList.add('hidden');
        document.getElementById('purchaseForm').reset();
    }

    function updateQuantity(delta) {
        const quantityInput = document.getElementById('quantity');
        const currentQty = parseInt(quantityInput.value);
        const newQty = currentQty + delta;
        
        if (newQty >= 1 && newQty <= currentStock) {
            quantityInput.value = newQty;
            updateSubtotal();
        }
    }

    function updateSubtotal() {
        const quantity = parseInt(document.getElementById('quantity').value);
        const subtotal = quantity * currentPrice;
        document.getElementById('subtotal').textContent = formatPrice(subtotal);
    }

    function formatPrice(price) {
        return new Intl.NumberFormat('id-ID').format(price);
    }

    // Close modal when clicking outside
    document.getElementById('purchaseModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePurchaseModal();
        }
    });

    // Form validation before submit
    document.getElementById('purchaseForm').addEventListener('submit', function(e) {
        // Add hidden status_pembelian field with value 'beli'
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status_pembelian';
        statusInput.value = 'beli';
        this.appendChild(statusInput);
        
        const requiredFields = ['shipping_address', 'phone_number', 'description'];
        let isValid = true;

        requiredFields.forEach(field => {
            const element = document.getElementById(field);
            if (!element.value.trim()) {
                isValid = false;
                element.classList.add('border-red-500');
            } else {
                element.classList.remove('border-red-500');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua data yang diperlukan');
        }
    });

    function addToCart() {
    // Get form values
    const productId = document.getElementById('productId').value;
    const sizeId = document.getElementById('sizeId').value;
    const quantity = document.getElementById('quantity').value;
    
    // Validate required fields are present
    if (!productId || !sizeId || !quantity) {
        alert('Missing required product information');
        return;
    }
    
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Use FormData for a traditional form submit
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('size_id', sizeId);
    formData.append('quantity', quantity);
    formData.append('payment', 'Temporary');
    formData.append('status_pembelian', 'keranjang');
    formData.append('payment_method', 'pending');
    formData.append('shipping_address', 'Temporary'); 
    formData.append('phone_number', 'Temporary');     
    formData.append('description', 'Added to cart');
    formData.append('_token', csrfToken);
    
    // Send AJAX request
    fetch('{{ route("purchases.store") }}', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',  // Important to identify AJAX request
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
    .then(response => {
        // Check if the response is JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(data => {
                if (!response.ok) {
                    return Promise.reject(data);
                }
                return data;
            });
        } else {
            // If not JSON, there's an error - the server returned HTML
            return Promise.reject({
                message: 'Server returned an unexpected response format. Please try again later.'
            });
        }
    })
    .then(data => {
        // Success message
        const notification = document.createElement('div');
        notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        notification.textContent = 'Item ditambahkan ke keranjang!';
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
        
        // Update cart count
        updateCartCount();
        
        // Close the modal
        closePurchaseModal();
    })
    .catch(error => {
        window.location.href = "{{ route('login') }}"
        console.error('Error:', error);
        alert('Error menambahkan item ke keranjang: ' + (error.message || 'Unknown error'));
    });
}

    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const cartCount = document.getElementById('cartCount');
                if (cartCount) {
                    cartCount.textContent = data.count;
                }
            });
    }
</script>
</html>
@endsection