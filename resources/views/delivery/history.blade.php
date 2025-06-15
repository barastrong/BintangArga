{{-- resources/views/delivery/history.blade.php --}}
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
                            <h1 class="text-2xl font-bold text-gray-900">Riwayat Pengiriman</h1>
                            <p class="text-gray-600 mt-1">Daftar semua pesanan yang telah berhasil dikirim</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Stats Summary -->
                            <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg px-4 py-2">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-orange-600 mr-2"></i>
                                    <div>
                                        <p class="text-sm text-orange-600 font-medium">Total Selesai</p>
                                        <p class="text-lg font-bold text-orange-700">{{ $completedOrders->total() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <!-- <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <button class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-4 py-2 rounded-lg text-sm transition-all duration-200">
                                <i class="fas fa-download mr-2"></i>
                                Export
                            </button>
                        </div>
                    </div>
                </div> -->

                <!-- History List -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    @if($completedOrders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pesanan
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Produk
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pembeli
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Penjual
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal Selesai
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($completedOrders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-orange-100 to-orange-200 flex items-center justify-center">
                                                        <i class="fas fa-box text-orange-600"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        #{{ $order->id }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $order->created_at->format('d M Y, H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($order->product->gambar)
                                                    <img src="{{ asset('storage/' . $order->product->gambar) }}" 
                                                         alt="{{ $order->product->nama_barang }}" 
                                                         class="h-10 w-10 rounded-lg object-cover mr-3">
                                                @else
                                                    <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center mr-3">
                                                        <i class="fas fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $order->product->nama_barang }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        Qty: {{ $order->quantity }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $order->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $order->alamat_pengiriman }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $order->seller->nama_toko ?? $order->seller->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $order->seller->alamat ?? 'Alamat tidak tersedia' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $order->updated_at->format('d M Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $order->updated_at->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                + Ongkir: Rp {{ number_format($order->ongkir, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('delivery.order-detail', $order->id) }}" 
                                               class="text-orange-600 hover:text-orange-900 mr-3">
                                                <i class="fas fa-eye mr-1"></i>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                            <div class="flex-1 flex justify-between sm:hidden">
                                @if($completedOrders->previousPageUrl())
                                    <a href="{{ $completedOrders->previousPageUrl() }}" 
                                       class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Previous
                                    </a>
                                @endif
                                @if($completedOrders->nextPageUrl())
                                    <a href="{{ $completedOrders->nextPageUrl() }}" 
                                       class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Next
                                    </a>
                                @endif
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Showing {{ $completedOrders->firstItem() }} to {{ $completedOrders->lastItem() }} of {{ $completedOrders->total() }} results
                                    </p>
                                </div>
                                <div>
                                    {{ $completedOrders->links() }}
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="mx-auto h-24 w-24 text-gray-400">
                                <i class="fas fa-history text-6xl"></i>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada riwayat pengiriman</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Riwayat pengiriman akan muncul setelah Anda menyelesaikan pesanan pertama.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('delivery.orders') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700">
                                    <i class="fas fa-list mr-2"></i>
                                    Lihat Pesanan Aktif
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Summary Cards -->
                @if($completedOrders->count() > 0)
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 bg-gradient-to-r from-orange-100 to-orange-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check-circle text-orange-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Total Pengiriman Selesai</h3>
                                <p class="text-2xl font-bold text-orange-600">{{ $completedOrders->total() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 bg-gradient-to-r from-orange-100 to-orange-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar text-orange-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Bulan Ini</h3>
                                <p class="text-2xl font-bold text-orange-600">
                                    {{ $completedOrders->where('updated_at', '>=', now()->startOfMonth())->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar (Now on the right) -->
            <div class="w-64 flex-shrink-0">
                @include('delivery.partials.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection