@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Riwayat Pembelian</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($purchases->isEmpty())
        <p class="text-gray-600">Anda belum memiliki riwayat pembelian.</p>
    @else
        <div class="bg-white shadow overflow-hidden rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($purchases as $purchase)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $purchase->product->nama_barang }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $purchase->size->size }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $purchase->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $purchase->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $purchase->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $purchase->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($purchase->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('purchases.show', $purchase) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                            @if($purchase->status === 'pending')
                            <form action="{{ route('purchases.cancel', $purchase) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="ml-2 text-red-600 hover:text-red-900">Batalkan</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $purchases->links() }}
        </div>
    @endif
</div>
</body>
</html>
@endsection