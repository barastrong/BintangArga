@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-6">
            <!-- Main Content -->
            <div class="flex-1">
                <!-- Header -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">Detail Pesanan</h1>
                            <p class="text-gray-600 mt-1">Order ID: #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <a href="{{ route('delivery.orders') }}" 
                           class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-4 py-2 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Informasi Pesanan -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-lg font-semibold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent mb-4">Informasi Pesanan</h2>
                        
                        <!-- Status Pesanan -->
                        <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-4 mb-6 border border-orange-200">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">Status Pengiriman:</span>
                                @php
                                    $statusConfig = [
                                        'pending' => ['class' => 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300', 'text' => 'Menunggu Pickup'],
                                        'picked_up' => ['class' => 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300', 'text' => 'Telah Diambil'],
                                        'shipping' => ['class' => 'bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 border border-orange-300', 'text' => 'Dalam Pengiriman'],
                                        'delivered' => ['class' => 'bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300', 'text' => 'Telah Diterima']
                                    ];
                                    $currentStatus = $statusConfig[$order->status_pengiriman] ?? ['class' => 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border border-gray-300', 'text' => 'Status Tidak Diketahui'];
                                @endphp
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $currentStatus['class'] }}">
                                    {{ $currentStatus['text'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Detail Produk -->
                        <div class="border-b border-orange-200 pb-4 mb-4">
                            <h3 class="font-medium bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent mb-3">Detail Produk</h3>
                            <div class="flex items-start space-x-4">
                                @if($order->product->gambar)
                                    <img src="{{ asset('storage/' . $order->product->gambar) }}" 
                                         alt="{{ $order->product->nama_barang }}"
                                         class="w-16 h-16 object-cover rounded-lg border-2 border-orange-200">
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center border-2 border-orange-300">
                                        <i class="fas fa-image text-orange-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $order->product->nama_barang }}</h4>
                                    <p class="text-sm text-gray-600">Jumlah: {{ $order->quantity }} pcs</p>
                                    <p class="text-sm font-medium bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Penjual -->
                        <div class="border-b border-orange-200 pb-4 mb-4">
                            <h3 class="font-medium bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent mb-3">Informasi Penjual</h3>
                            <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-3 border border-orange-200">
                                <p class="text-sm"><span class="font-medium text-orange-700">Nama:</span> {{ $order->seller->nama_penjual }}</p>
                                <p class="text-sm"><span class="font-medium text-orange-700">Email:</span> {{ $order->seller->email_penjual }}</p>
                                <p class="text-sm"><span class="font-medium text-orange-700">Telepon:</span> {{ $order->seller->no_telepon }}</p>
                                <p class="text-sm"><span class="font-medium text-orange-700">Alamat:</span> {{ $order->seller->alamat }}</p>
                            </div>
                        </div>

                        <!-- Informasi Pembeli -->
                        <div>
                            <h3 class="font-medium bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent mb-3">Informasi Pembeli</h3>
                            <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-3 border border-orange-200">
                                <p class="text-sm"><span class="font-medium text-orange-700">Nama:</span> {{ $order->user->name }}</p>
                                <p class="text-sm"><span class="font-medium text-orange-700">Email:</span> {{ $order->user->email }}</p>
                                <p class="text-sm"><span class="font-medium text-orange-700">Alamat Pengiriman:</span> {{ $order->shipping_address }}</p>
                                <p class="text-sm"><span class="font-medium text-orange-700">Catatan:</span> {{ $order->description ?? 'Tidak ada catatan' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Update Status -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-lg font-semibold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent mb-4">Update Status</h2>
                        
                        @if($order->status_pengiriman !== 'delivered')
                            <form action="{{ route('delivery.update-status', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-orange-700 mb-2">
                                        Status Pengiriman
                                    </label>
                                    <select name="status_pengiriman" 
                                            class="w-full border-2 border-orange-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-gradient-to-r from-orange-50 to-white">
                                        @if($order->status_pengiriman === 'pending')
                                            <option value="picked_up">Telah Diambil</option>
                                        @elseif($order->status_pengiriman === 'picked_up')
                                            <option value="shipping">Dalam Pengiriman</option>
                                        @elseif($order->status_pengiriman === 'shipping')
                                            <option value="delivered">Telah Diterima</option>
                                        @endif
                                    </select>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-2 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <i class="fas fa-check mr-2"></i>
                                    Update Status
                                </button>
                            </form>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-check-circle text-green-500 text-4xl mb-3"></i>
                                <p class="text-green-600 font-medium">Pesanan Telah Selesai</p>
                                <p class="text-sm text-gray-500 mt-1">Status tidak dapat diubah lagi</p>
                            </div>
                        @endif

                        <!-- Timeline Status -->
                        <div class="mt-6 pt-6 border-t border-orange-200">
                            <h3 class="text-sm font-medium bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent mb-3">Timeline Pengiriman</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-gradient-to-r from-green-400 to-green-500 rounded-full shadow-sm"></div>
                                    <div class="ml-3">
                                        <p class="text-xs font-medium text-gray-900">Pesanan Dibuat</p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                
                                @if(in_array($order->status_pengiriman, ['picked_up', 'shipping', 'delivered']))
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-gradient-to-r from-blue-400 to-blue-500 rounded-full shadow-sm"></div>
                                        <div class="ml-3">
                                            <p class="text-xs font-medium text-gray-900">Pesanan Diambil</p>
                                            <p class="text-xs text-gray-500">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endif
                                
                                @if(in_array($order->status_pengiriman, ['shipping', 'delivered']))
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 {{ $order->status_pengiriman === 'delivered' ? 'bg-gradient-to-r from-orange-400 to-orange-500' : 'bg-gray-300' }} rounded-full shadow-sm"></div>
                                        <div class="ml-3">
                                            <p class="text-xs font-medium text-gray-900">Dalam Pengiriman</p>
                                            @if($order->status_pengiriman !== 'shipping')
                                                <p class="text-xs text-gray-500">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                @if($order->status_pengiriman === 'delivered')
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-gradient-to-r from-green-400 to-green-500 rounded-full shadow-sm"></div>
                                        <div class="ml-3">
                                            <p class="text-xs font-medium text-gray-900">Pesanan Diterima</p>
                                            <p class="text-xs text-gray-500">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-64 flex-shrink-0">
                @include('delivery.partials.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection