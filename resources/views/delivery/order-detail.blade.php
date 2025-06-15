@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-6">
            <!-- Sidebar -->
            <div class="w-64 flex-shrink-0">
                @include('delivery.partials.sidebar')
            </div>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Header -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan</h1>
                            <p class="text-gray-600 mt-1">Order ID: #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <a href="{{ route('delivery.orders') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Informasi Pesanan -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pesanan</h2>
                        
                        <!-- Status Pesanan -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">Status Pengiriman:</span>
                                @php
                                    $statusConfig = [
                                        'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Menunggu Pickup'],
                                        'picked_up' => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'Telah Diambil'],
                                        'shipping' => ['class' => 'bg-purple-100 text-purple-800', 'text' => 'Dalam Pengiriman'],
                                        'delivered' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Telah Diterima']
                                    ];
                                    $currentStatus = $statusConfig[$order->status_pengiriman] ?? ['class' => 'bg-gray-100 text-gray-800', 'text' => 'Status Tidak Diketahui'];
                                @endphp
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $currentStatus['class'] }}">
                                    {{ $currentStatus['text'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Detail Produk -->
                        <div class="border-b pb-4 mb-4">
                            <h3 class="font-medium text-gray-900 mb-3">Detail Produk</h3>
                            <div class="flex items-start space-x-4">
                                @if($order->product->gambar_produk)
                                    <img src="{{ asset('storage/' . $order->product->gambar_produk) }}" 
                                         alt="{{ $order->product->nama_produk }}"
                                         class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $order->product->nama_produk }}</h4>
                                    <p class="text-sm text-gray-600">Jumlah: {{ $order->jumlah }} pcs</p>
                                    <p class="text-sm font-medium text-blue-600">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Penjual -->
                        <div class="border-b pb-4 mb-4">
                            <h3 class="font-medium text-gray-900 mb-3">Informasi Penjual</h3>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-sm"><span class="font-medium">Nama:</span> {{ $order->seller->nama_toko }}</p>
                                <p class="text-sm"><span class="font-medium">Email:</span> {{ $order->seller->email }}</p>
                                <p class="text-sm"><span class="font-medium">Telepon:</span> {{ $order->seller->no_telepon }}</p>
                                <p class="text-sm"><span class="font-medium">Alamat:</span> {{ $order->seller->alamat }}</p>
                            </div>
                        </div>

                        <!-- Informasi Pembeli -->
                        <div>
                            <h3 class="font-medium text-gray-900 mb-3">Informasi Pembeli</h3>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-sm"><span class="font-medium">Nama:</span> {{ $order->user->name }}</p>
                                <p class="text-sm"><span class="font-medium">Email:</span> {{ $order->user->email }}</p>
                                <p class="text-sm"><span class="font-medium">Alamat Pengiriman:</span> {{ $order->alamat_pengiriman }}</p>
                                <p class="text-sm"><span class="font-medium">Catatan:</span> {{ $order->catatan ?? 'Tidak ada catatan' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Update Status -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h2>
                        
                        @if($order->status_pengiriman !== 'delivered')
                            <form action="{{ route('delivery.update-status', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Status Pengiriman
                                    </label>
                                    <select name="status_pengiriman" 
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors">
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
                        <div class="mt-6 pt-6 border-t">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Timeline Pengiriman</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <div class="ml-3">
                                        <p class="text-xs font-medium text-gray-900">Pesanan Dibuat</p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                
                                @if(in_array($order->status_pengiriman, ['picked_up', 'shipping', 'delivered']))
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                        <div class="ml-3">
                                            <p class="text-xs font-medium text-gray-900">Pesanan Diambil</p>
                                            <p class="text-xs text-gray-500">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endif
                                
                                @if(in_array($order->status_pengiriman, ['shipping', 'delivered']))
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 {{ $order->status_pengiriman === 'delivered' ? 'bg-purple-500' : 'bg-gray-300' }} rounded-full"></div>
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
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
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
        </div>
    </div>
</div>
@endsection