@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout</title>
</head>
<body>
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 mb-8">
            <button onclick="handleBackButton()" class="text-gray-600 hover:text-orange-500 transition-transform hover:scale-110">
                <i class="fas fa-arrow-left text-2xl"></i>
            </button>
            <h1 class="text-3xl font-bold text-gray-800">Checkout</h1>
        </div>

        <form id="checkout-form" action="{{ route('cart.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-xl shadow-md">
                        <h2 class="text-xl font-semibold text-gray-800 p-6 border-b">Barang Pesanan</h2>
                        <div class="p-6 space-y-4">
                            @forelse($selectedItems as $item)
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
                                {{-- Tambahan untuk mengirim status_pembelian --}}
                                <input type="hidden" class="item-status" data-item-id="{{ $item->id }}" value="{{ $item->status_pembelian }}">
                            @empty
                                <p class="text-gray-500">Tidak ada item yang dipilih untuk checkout.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Pengiriman</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                                <textarea name="shipping_address" id="shipping_address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required>{{ old('shipping_address', Auth::user()->address) }}</textarea>
                            </div>
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', Auth::user()->phone) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" required>
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Catatan Pembelian (opsional)</label>
                                <textarea name="description" id="description" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-24 space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pajak (10%)</span>
                                <span class="font-medium">Rp {{ number_format($totalPrice * 0.1, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center border-t pt-4">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            @php
                                $finalTotal = $totalPrice + ($totalPrice * 0.1);
                            @endphp
                            <span class="text-xl font-bold text-orange-600">Rp {{ number_format($finalTotal, 0, ',', '.') }}</span>
                            <input type="hidden" name="total_with_tax" value="{{ $finalTotal }}">
                        </div>

                        <div>
                            <label class="block text-base font-semibold text-gray-700 mb-3">Metode Pembayaran</label>
                            <div class="space-y-3">
                                <label for="payment_gopay" class="flex items-center p-3 border rounded-lg cursor-pointer hover:border-orange-500 transition has-[:checked]:bg-orange-50 has-[:checked]:border-orange-500">
                                    <input type="radio" name="payment_method" value="gopay" id="payment_gopay" class="h-4 w-4 text-orange-600 border-gray-300 focus:ring-orange-500" onchange="showPaymentDetails('gopay')">
                                    <span class="ml-3 font-medium text-sm text-gray-700">Gopay</span>
                                </label>
                                <label for="payment_dana" class="flex items-center p-3 border rounded-lg cursor-pointer hover:border-orange-500 transition has-[:checked]:bg-orange-50 has-[:checked]:border-orange-500">
                                    <input type="radio" name="payment_method" value="dana" id="payment_dana" class="h-4 w-4 text-orange-600 border-gray-300 focus:ring-orange-500" onchange="showPaymentDetails('dana')">
                                    <span class="ml-3 font-medium text-sm text-gray-700">Dana</span>
                                </label>
                                <label for="payment_bank" class="flex items-center p-3 border rounded-lg cursor-pointer hover:border-orange-500 transition has-[:checked]:bg-orange-50 has-[:checked]:border-orange-500">
                                    <input type="radio" name="payment_method" value="bank_transfer" id="payment_bank" class="h-4 w-4 text-orange-600 border-gray-300 focus:ring-orange-500" onchange="showPaymentDetails('bank_transfer')">
                                    <span class="ml-3 font-medium text-sm text-gray-700">Transfer Bank</span>
                                </label>
                                <label for="payment_qris" class="flex items-center p-3 border rounded-lg cursor-pointer hover:border-orange-500 transition has-[:checked]:bg-orange-50 has-[:checked]:border-orange-500">
                                    <input type="radio" name="payment_method" value="qris" id="payment_qris" class="h-4 w-4 text-orange-600 border-gray-300 focus:ring-orange-500" onchange="showPaymentDetails('qris')">
                                    <span class="ml-3 font-medium text-sm text-gray-700">QRIS</span>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ================================================================= -->
                        <!-- PERBAIKAN KRITIS DI SINI: Gunakan data pembayaran platform, bukan per penjual -->
                        <!-- ================================================================= -->
                        <div id="payment-details" class="hidden">
                            <div id="gopay-details" class="payment-detail hidden">
                                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                    <h3 class="font-semibold text-green-800 mb-2">Pembayaran dengan Gopay</h3>
                                    <p class="text-sm text-green-700 mb-2">Silakan transfer ke nomor Gopay berikut:</p>
                                    <div class="bg-white p-3 rounded border">
                                        <p class="font-mono text-lg font-bold text-green-800">081234567890</p>
                                        <p class="text-sm text-gray-600">a.n. ArgaBintang Store</p>
                                    </div>
                                    <p class="text-xs text-green-600 mt-2">*Pastikan nominal transfer sesuai dengan total pembayaran</p>
                                </div>
                            </div>

                            <div id="dana-details" class="payment-detail hidden">
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                    <h3 class="font-semibold text-blue-800 mb-2">Pembayaran dengan Dana</h3>
                                    <p class="text-sm text-blue-700 mb-2">Silakan transfer ke nomor Dana berikut:</p>
                                    <div class="bg-white p-3 rounded border">
                                        <p class="font-mono text-lg font-bold text-blue-800">081234567890</p>
                                        <p class="text-sm text-gray-600">a.n. ArgaBintang Store</p>
                                    </div>
                                    <p class="text-xs text-blue-600 mt-2">*Pastikan nominal transfer sesuai dengan total pembayaran</p>
                                </div>
                            </div>

                            <div id="bank_transfer-details" class="payment-detail hidden">
                                <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                    <h3 class="font-semibold text-purple-800 mb-2">Transfer Bank</h3>
                                    <p class="text-sm text-purple-700 mb-2">Silakan transfer ke rekening berikut:</p>
                                    <div class="bg-white p-3 rounded border">
                                        <p class="text-sm text-gray-600">Bank BCA</p>
                                        <p class="font-mono text-lg font-bold text-purple-800">1234567890</p>
                                        <p class="text-sm text-gray-600">a.n. PT ArgaBintang Sejahtera</p>
                                    </div>
                                    <p class="text-xs text-purple-600 mt-2">*Pastikan nominal transfer sesuai dengan total pembayaran</p>
                                </div>
                            </div>

                            <div id="qris-details" class="payment-detail hidden">
                                <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                                    <h3 class="font-semibold text-orange-800 mb-2">Pembayaran dengan QRIS</h3>
                                    <p class="text-sm text-orange-700 mb-2">Scan QR Code berikut untuk pembayaran:</p>
                                    <div class="bg-white p-4 rounded border text-center">
                                        <img src="{{ asset('images/qris_placeholder.png') }}" alt="QRIS Code" class="w-32 h-32 mx-auto mb-2">
                                        <p class="text-sm text-gray-600">Scan dengan aplikasi pembayaran digital</p>
                                    </div>
                                </div>
                            </div>
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

<script>
function showPaymentDetails(paymentMethod) {
    const paymentDetails = document.getElementById('payment-details');
    const allDetails = document.querySelectorAll('.payment-detail');
    
    allDetails.forEach(detail => {
        detail.classList.add('hidden');
    });
    
    const selectedDetail = document.getElementById(paymentMethod + '-details');
    if (selectedDetail) {
        paymentDetails.classList.remove('hidden');
        selectedDetail.classList.remove('hidden');
    }
}

function handleBackButton() {
    const itemStatuses = [];
    document.querySelectorAll('.item-status').forEach(function(element) {
        itemStatuses.push({
            id: element.getAttribute('data-item-id'),
            status: element.value
        });
    });

    const beliItems = itemStatuses.filter(item => item.status === 'beli');

    if (beliItems.length > 0) {
        const itemIds = beliItems.map(item => item.id);

        fetch('{{ route("cart.cancel-direct-purchase") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                item_ids: itemIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.history.back();
            } else {
                alert('Terjadi kesalahan: ' + (data.message || 'Gagal menghapus item'));
                window.history.back(); // Tetap kembali meskipun gagal
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan jaringan');
            window.history.back(); // Tetap kembali meskipun gagal
        });
    } else {
        window.history.back();
    }
}
</script>

</body>
</html>
@endsection