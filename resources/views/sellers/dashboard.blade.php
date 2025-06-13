@extends('layouts.app')

@section('content')
<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Kolom Sidebar -->
            <div class="lg:col-span-1">
                {{-- Kita akan rapikan sidebar di langkah berikutnya --}}
                @include('sellers.partials.sidebar')
            </div>

            <!-- Kolom Konten Utama -->
            <div class="lg:col-span-3 space-y-8">
                
                <!-- Welcome Card -->
                <div class="bg-gradient-to-r from-orange-500 to-amber-500 text-white p-8 rounded-xl shadow-lg">
                    <h1 class="text-3xl font-bold">Selamat Datang, {{ $seller->nama_penjual }}!</h1>
                    <p class="mt-2 opacity-90">Ini adalah pusat kendali tokomu. Kelola produk, lihat pesanan, dan pantau performa penjualanmu di sini.</p>
                </div>

                <!-- Kartu Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Produk -->
                    <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
                        <p class="text-sm font-medium text-gray-500">Total Produk</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Product::where('seller_id', $seller->id)->count() }}</p>
                    </div>
                    <!-- Pesanan Baru -->
                    <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-orange-500">
                        <p class="text-sm font-medium text-gray-500">Pesanan Baru (Pending)</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Purchase::where('seller_id', $seller->id)->where('status', 'pending')->count() }}</p>
                    </div>
                    <!-- Total Stok -->
                    <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
                        <p class="text-sm font-medium text-gray-500">Total Stok</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Product::where('seller_id', $seller->id)->with('sizes')->get()->sum(function($product) { return $product->sizes->sum('stock'); }) }}</p>
                    </div>
                </div>

                <!-- Daftar Produk Terbaru -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800">Produk Terbaru</h2>
                        <a href="{{ route('seller.products') }}" class="text-sm font-medium text-orange-600 hover:text-orange-800">Lihat Semua</a>
                    </div>
                    
                    @php
                        $latestProducts = \App\Models\Product::where('seller_id', $seller->id)
                            ->with('category', 'sizes')
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @if($latestProducts->isEmpty())
                        <div class="text-center py-16 px-6">
                            <i class="fas fa-box-open text-5xl text-gray-300 mb-4"></i>
                            <p class="text-lg text-gray-600">Kamu belum punya produk.</p>
                            <a href="{{ route('products.create') }}" class="mt-4 inline-block bg-orange-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-orange-600 transition-colors">
                                Tambah Produk Pertama
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                                    <tr>
                                        <th class="px-6 py-3">Nama Barang</th>
                                        <th class="px-6 py-3">Kategori</th>
                                        <th class="px-6 py-3">Stok</th>
                                        <th class="px-6 py-3">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestProducts as $product)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $product->nama_barang }}</td>
                                        <td class="px-6 py-4">
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-1 rounded-full">{{ $product->category->nama ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-6 py-4 font-medium">{{ $product->sizes->sum('stock') }}</td>
                                        <td class="px-6 py-4 font-semibold text-gray-700">
                                            @php
                                                $minPrice = $product->sizes->min('harga');
                                                $maxPrice = $product->sizes->max('harga');
                                            @endphp
                                            @if($minPrice == $maxPrice)
                                                Rp {{ number_format($minPrice, 0, ',', '.') }}
                                            @else
                                                Rp {{ number_format($minPrice, 0, ',', '.') }} - {{ number_format($maxPrice, 0, ',', '.') }}
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