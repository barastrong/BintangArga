@extends('layouts.app')

@section('content')
<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Kolom Sidebar -->
            <div class="lg:col-span-1">
                @include('sellers.partials.sidebar')
            </div>

            <!-- Kolom Konten Utama -->
            <div class="lg:col-span-3">
                <!-- Header Halaman -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">Manajemen Pesanan</h1>
                    {{-- Bisa ditambahkan tombol filter atau search di sini nanti --}}
                </div>

                <!-- Card Tabel Pesanan -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold text-gray-800">Daftar Pesanan Masuk</h2>
                    </div>
                    
                    @if($orders->isEmpty())
                        <div class="text-center py-16 px-6">
                            <i class="fas fa-receipt text-5xl text-gray-300 mb-4"></i>
                            <p class="text-lg text-gray-600">Belum ada pesanan yang masuk.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                                    <tr>
                                        <th class="px-6 py-3">ID</th>
                                        <th class="px-6 py-3">Pembeli</th>
                                        <th class="px-6 py-3">Produk</th>
                                        <th class="px-6 py-3">Detail</th>
                                        <th class="px-6 py-3">Total</th>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3">Tanggal</th>
                                        <th class="px-6 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium">#{{ $order->id }}</td>
                                        <td class="px-6 py-4">{{ $order->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $order->product->nama_barang ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">
                                            <div>Ukuran: {{ $order->size->size ?? 'N/A' }}</div>
                                            <div>Jumlah: {{ $order->quantity }}</div>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            {{-- Badge Status Modern --}}
                                            @if($order->status == 'completed' || $order->status == 'selesai')
                                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded-full">Selesai</span>
                                            @elseif($order->status == 'process' || $order->status == 'diproses')
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-1 rounded-full">Diproses</span>
                                            @elseif($order->status == 'pending')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-1 rounded-full">Menunggu</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-1 rounded-full">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            {{-- Tombol Aksi Sesuai Logika Lama --}}
                                            @if($order->status != 'completed' && $order->status != 'selesai' && $order->status != 'canceled' && $order->status != 'cancelled')
                                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                                    <div>
                                                        <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-3 py-1 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                                                            Aksi
                                                            <i class="fas fa-chevron-down -mr-1 ml-2 h-4 w-4"></i>
                                                        </button>
                                                    </div>
                                                    <div x-show="open" @click.away="open = false" 
                                                         x-transition:enter="transition ease-out duration-100"
                                                         x-transition:enter-start="transform opacity-0 scale-95"
                                                         x-transition:enter-end="transform opacity-100 scale-100"
                                                         x-transition:leave="transition ease-in duration-75"
                                                         x-transition:leave-start="transform opacity-100 scale-100"
                                                         x-transition:leave-end="transform opacity-0 scale-95"
                                                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                                        <div class="py-1" role="menu" aria-orientation="vertical">
                                                            <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="process">
                                                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                                                    Proses Pesanan
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST" class="block">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="completed">
                                                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                                                    Selesaikan Pesanan
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection