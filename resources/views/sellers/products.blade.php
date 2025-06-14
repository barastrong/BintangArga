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
                    <h1 class="text-3xl font-bold text-gray-800">Produk Saya</h1>
                    <a href="{{ route('products.create') }}" class="mt-4 sm:mt-0 inline-flex items-center gap-2 bg-orange-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-orange-600 transition-colors">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Produk</span>
                    </a>
                </div>

                <!-- Card Tabel Produk -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    @if($products->isEmpty())
                        <div class="text-center py-16 px-6">
                            <img src="{{ asset('/empty-box.svg') }}" alt="No Products" class="mx-auto h-24 mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">Anda belum memiliki produk</h3>
                            <p class="text-gray-500 mt-2 mb-4">Mulai tambahkan produk untuk dijual di platform kami.</p>
                            <a href="{{ route('products.create') }}" class="inline-block bg-orange-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-orange-600 transition-colors">
                                Tambah Produk Pertama Anda
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                                    <tr>
                                        <th class="px-6 py-3">Produk</th>
                                        <th class="px-6 py-3">Kategori</th>
                                        <th class="px-6 py-3">Stok</th>
                                        <th class="px-6 py-3">Harga</th>
                                        <th class="px-6 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $product->gambar ? asset('storage/' . $product->gambar) : asset('images/no-image.png') }}" alt="{{ $product->nama_barang }}" class="w-12 h-12 rounded-md object-cover">
                                                <span class="font-semibold text-gray-800">{{ $product->nama_barang }}</span>
                                            </div>
                                        </td>
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
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center items-center gap-2">
                                                <a href="{{ route('products.show', $product->id) }}" class="p-2 text-gray-400 hover:text-blue-600" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product->id) }}" class="p-2 text-gray-400 hover:text-yellow-600" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
                        <div class="p-4 border-t">
                            {{ $products->links() }}
                        </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection