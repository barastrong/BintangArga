@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Checkout Pemesanan</title>
</head>
<body>
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Tombol Kembali -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-800 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <!-- Kolom Gambar -->
                <div class="p-4 sm:p-6">
                    <div class="aspect-w-1 aspect-h-1">
                        <img id="mainImage" src="{{ $product->sizes->first() ? Storage::url($product->sizes->first()->gambar_size) : 'https://via.placeholder.com/600' }}" 
                             alt="{{ $product->nama_barang }}" 
                             class="w-full h-full object-cover rounded-lg shadow-md">
                    </div>
                    @if($product->sizes->count() > 1)
                    <div class="grid grid-cols-5 gap-3 mt-4">
                        @foreach($product->sizes as $size)
                            <div class="aspect-w-1 aspect-h-1">
                                <img src="{{ Storage::url($size->gambar_size) }}" 
                                     alt="{{ $product->nama_barang }} - {{ $size->size }}"
                                     onclick="updateMainImage('{{ Storage::url($size->gambar_size) }}')"
                                     class="w-full h-full object-cover rounded-md cursor-pointer border-2 border-transparent hover:border-orange-500 transition">
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Kolom Detail & Aksi -->
                <div class="p-6 sm:p-8 flex flex-col">
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">{{ $product->nama_barang }}</h1>
                    
                    <!-- Info Rating & Terjual -->
                    <div class="flex items-center flex-wrap gap-x-4 gap-y-2 mt-3 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                            <span class="font-semibold">{{ number_format($averageRating, 1) }}</span>
                            <span class="text-gray-400 ml-1">({{ $product->ratings->count() }} ulasan)</span>
                        </div>
                        <span class="text-gray-300 hidden sm:block">|</span>
                        <div class="text-gray-600 font-medium">
                            <span>{{ $product->purchases->where('status_pembelian', '!=', 'keranjang')->count() }}</span>
                            <span class="text-gray-500">terjual</span>
                        </div>
                    </div>

                    <!-- Info Penjual -->
                    <div class="mt-6 pt-6 border-t">
                        <p class="text-sm text-gray-500 mb-2">Dijual oleh:</p>
                        <a class="flex items-center gap-4 group">
                            <img src="{{ asset('storage/' . $product->seller->foto_profil) }}" alt="Profil Penjual" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 group-hover:border-orange-500 transition">
                            <div>
                                <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition">{{ $product->seller->nama_penjual }}</p>
                                <span class="text-xs text-white bg-orange-500 px-2 py-0.5 rounded-full">Toko Terpercaya</span>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Deskripsi -->
                    <div class="mt-6">
                        <h2 class="font-semibold text-lg mb-2 text-gray-800">Deskripsi Produk</h2>
                        <p class="text-gray-600 text-base leading-relaxed whitespace-pre-wrap">{{ $product->description }}</p>
                    </div>

                    <!-- Size Chart (Bagian Aksi) -->
                    <div class="mt-auto pt-8">
                        <h2 class="font-semibold text-lg mb-4 text-gray-800">Pilih Ukuran & Beli</h2>
                        <div class="space-y-3">
                            @forelse($product->sizes as $size)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border hover:border-orange-400 transition">
                                <div class="flex items-center gap-3">
                                    <img src="{{ Storage::url($size->gambar_size) }}" alt="{{ $size->size }}" class="w-12 h-12 object-cover rounded-md hidden sm:block">
                                    <div>
                                        <h3 class="font-bold text-gray-800">{{ $size->size }}</h3>
                                        <p class="text-orange-600 font-semibold">Rp {{ number_format($size->harga, 0, ',', '.') }}</p>
                                        <p class="text-xs {{ $size->stock > 5 ? 'text-green-600' : ($size->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                            Stok: {{ $size->stock > 0 ? $size->stock : 'Habis' }}
                                        </p>
                                    </div>
                                </div>
                                @if($size->stock > 0)
                                    <button onclick="openPurchaseModal('{{ $size->id }}', '{{ $size->size }}', {{ $size->harga }}, {{ $size->stock }}, '{{ $product->id }}')" 
                                           class="bg-orange-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-orange-600 transition-colors shadow-sm flex items-center gap-2">
                                        <i class="fas fa-shopping-cart text-sm"></i>
                                        <span>Beli</span>
                                    </button>
                                @else
                                    <button disabled class="bg-gray-200 text-gray-500 font-semibold py-2 px-4 rounded-md cursor-not-allowed">Stok Habis</button>
                                @endif
                            </div>
                            @empty
                            <div class="p-4 bg-red-50 text-red-700 rounded-lg text-center">
                                <p>Saat ini tidak ada ukuran yang tersedia untuk produk ini.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Reviews Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Ulasan Pelanggan</h2>
            @if($product->ratings->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($product->ratings->take(4) as $rating)
                        <div class="bg-white p-5 rounded-xl shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-3">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $rating->user->profile_image ? asset('storage/' . $rating->user->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($rating->user->name).'&color=FFFFFF&background=F97316' }}" alt="{{ $rating->user->name }}">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $rating->user->name ?? 'Anonymous' }}</p>
                                        <p class="text-xs text-gray-400">{{ $rating->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= $rating->rating; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                    @for($i = $rating->rating + 1; $i <= 5; $i++)
                                        <i class="far fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 mt-3 pl-13">{{ $rating->review ?: 'Tidak ada ulasan tertulis.' }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-8 rounded-lg shadow-sm text-center">
                    <p class="text-gray-600">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Purchase Modal (Struktur tidak diubah, hanya memastikan konsistensi) -->
<div id="purchaseModal" class="fixed inset-0 bg-black bg-opacity-60 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-lg w-full max-h-[90vh] flex flex-col" @click.away="closePurchaseModal()">
        <!-- Header -->
        <div class="border-b px-6 py-4 flex justify-between items-center flex-shrink-0">
            <h3 class="text-xl font-semibold text-gray-900">Detail Pembelian</h3>
            <button onclick="closePurchaseModal()" class="text-gray-400 hover:text-gray-600 transition">×</button>
        </div>
        <!-- Body -->
        <div class="overflow-y-auto">
            <form id="purchaseForm" method="POST" action="{{ route('purchases.store') }}" class="p-6">
                @csrf
                <input type="hidden" name="product_id" id="productId">
                <input type="hidden" name="size_id" id="sizeId">
                <input type="hidden" name="status_pembelian" value="beli">
                
                {{-- Konten form di sini sudah cukup bagus, tidak perlu banyak diubah --}}
                <div class="mb-4">
                    <h4 class="font-semibold text-lg text-gray-800 mb-2">{{ $product->nama_barang }}</h4>
                    <p class="text-gray-600">Ukuran: <span id="selectedSize" class="font-medium"></span></p>
                    <p class="text-gray-600">Harga Satuan: Rp <span id="selectedPrice" class="font-medium"></span></p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                    <div class="flex items-center">
                        <button type="button" onclick="updateQuantity(-1)" class="px-3 py-1 border rounded-l-md hover:bg-gray-100">-</button>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" class="w-16 text-center border-t border-b focus:outline-none" readonly>
                        <button type="button" onclick="updateQuantity(1)" class="px-3 py-1 border rounded-r-md hover:bg-gray-100">+</button>
                        <span class="text-sm text-gray-500 ml-4">Stok tersedia: <span id="availableStock">0</span></span>
                    </div>
                </div>

                <input type="hidden" name="shipping_address" id="shipping_address" value="Will be filled at checkout">
                <input type="hidden" name="phone_number" id="phone_number" value="Will be filled at checkout">
                <input type="hidden" name="description" id="description" value="Direct purchase - details at checkout">
                <!-- <div class="mb-4">
                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Pengiriman</label>
                    <textarea name="shipping_address" id="shipping_address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="tel" name="phone_number" id="phone_number" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Catatan Pembelian (opsional)</label>
                    <textarea name="description" id="description" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500"></textarea>
                </div> -->

                <div class="bg-orange-50 p-4 rounded-lg my-4">
                    <div class="flex justify-between font-bold text-lg">
                        <span class="text-gray-800">Total Pembayaran:</span>
                        <span class="text-orange-600">Rp <span id="subtotal">0</span></span>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="button" onclick="addToCart()" class="w-full text-center bg-orange-100 text-orange-600 font-semibold py-3 rounded-lg hover:bg-orange-200 transition">Tambah ke Keranjang</button>
                    <button type="submit" class="w-full text-center bg-orange-500 text-white font-semibold py-3 rounded-lg hover:bg-orange-600 transition">Beli Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script>
// Script to handle form submission validation and direct checkout
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
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
        
        updateCartCount();
        
        closePurchaseModal();
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.message && error.message.includes('Unauthenticated')) {
            window.location.href = "{{ route('login') }}";
        } else {
            alert('Error menambahkan item ke keranjang: ' + (error.message || 'Unknown error'));
        }
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