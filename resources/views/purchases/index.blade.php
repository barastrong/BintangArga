@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<style>
    .tab-active {
        border-bottom-width: 2px;
        border-indigo-500: solid;
        color: #4f46e5;
    }
</style>
<body>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Status Pesanan</h1>

    @if(session('success'))
        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Navigation Tabs -->
    <div class="flex border-b border-gray-200 mb-6">
        <button id="pending-tab" 
                onclick="changeTab('pending')" 
                class="py-2 px-4 font-medium text-sm focus:outline-none border-b-2 border-transparent tab-active">
            Dikemas
        </button>
        <button id="process-tab" 
                onclick="changeTab('process')" 
                class="py-2 px-4 font-medium text-sm focus:outline-none border-b-2 border-transparent">
            Diproses
        </button>
        <button id="completed-tab" 
                onclick="changeTab('completed')" 
                class="py-2 px-4 font-medium text-sm focus:outline-none border-b-2 border-transparent">
            Terkirim
        </button>
            <button id="selesai-tab" 
                onclick="changeTab('selesai')" 
                class="py-2 px-4 font-medium text-sm focus:outline-none border-b-2 border-transparent">
            Selesai
        </button>
    </div>

    <div id="pending-content" class="tab-content">
        @if(count($purchases->where('status', 'pending')) == 0)
            <p class="text-gray-600">Anda belum memiliki pesanan yang dikemas.</p>
        @else
            <div class="grid gap-4">
                @foreach($purchases->where('status', 'pending') as $purchase)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-1/4 p-4">
                            <img src="{{ Storage::url($purchase->product->sizes->first()->gambar_size) }}" 
                            alt="{{ $purchase->product->nama_barang }}"  class="w-full h-40 object-cover">
                        </div>
                        <div class="w-full md:w-3/4 p-4">
                            <h2 class="text-xl font-semibold">{{ $purchase->product->nama_barang }}</h2>
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                <div>
                                    <p class="text-gray-600">UKURAN</p>
                                    <p>{{ $purchase->size->size }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Jumlah</p>
                                    <p>{{ $purchase->quantity }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">Dikemas</span>
                                <div class="text-right">
                                    <p class="text-gray-600">Total harga</p>
                                    <p class="font-semibold">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('purchases.show', $purchase) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded mr-2">Detail</a>
                                <form action="{{ route('purchases.cancel', $purchase) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded">Batalkan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="process-content" class="tab-content hidden">
        @if(count($purchases->where('status', 'process')) == 0)
            <p class="text-gray-600">Anda belum memiliki pesanan yang diproses.</p>
        @else
            <div class="grid gap-4">
                @foreach($purchases->where('status', 'process') as $purchase)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-1/4 p-4">
                            <img src="{{ Storage::url($purchase->product->sizes->first()->gambar_size) }}" 
                            alt="{{ $purchase->product->nama_barang }}"  class="w-full h-40 object-cover">
                        </div>
                        <div class="w-full md:w-3/4 p-4">
                            <h2 class="text-xl font-semibold">{{ $purchase->product->nama_barang }}</h2>
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                <div>
                                    <p class="text-gray-600">UKURAN</p>
                                    <p>{{ $purchase->size->size }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Jumlah</p>
                                    <p>{{ $purchase->quantity }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">Diproses</span>
                                <div class="text-right">
                                    <p class="text-gray-600">Total harga</p>
                                    <p class="font-semibold">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('purchases.show', $purchase) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="completed-content" class="tab-content hidden">
    @if(count($purchases->where('status', 'completed')) == 0)
            <p class="text-gray-600">Anda belum memiliki pesanan yang selesai.</p>
        @else
            <div class="grid gap-4">
                @foreach($purchases->where('status', 'completed') as $purchase)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-1/4 p-4">
                            <img src="{{ Storage::url($purchase->product->sizes->first()->gambar_size) }}" 
                            alt="{{ $purchase->product->nama_barang }}"  class="w-full h-40 object-cover">
                        </div>
                        <div class="w-full md:w-3/4 p-4">
                            <h2 class="text-xl font-semibold">{{ $purchase->product->nama_barang }}</h2>
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                <div>
                                    <p class="text-gray-600">UKURAN</p>
                                    <p>{{ $purchase->size->size }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Jumlah</p>
                                    <p>{{ $purchase->quantity }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Dikirim</span>
                                <div class="text-right">
                                    <p class="text-gray-600">Total harga</p>
                                    <p class="font-semibold">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('purchases.show', $purchase) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="selesai-content" class="tab-content hidden">
    @if(count($purchases->where('status', 'selesai')) == 0)
            <p class="text-gray-600">Anda belum memiliki pesanan yang Terkirim.</p>
        @else
            <div class="grid gap-4">
                @foreach($purchases->where('status', 'selesai') as $purchase)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-1/4 p-4">
                            <img src="{{ Storage::url($purchase->product->sizes->first()->gambar_size) }}" 
                            alt="{{ $purchase->product->nama_barang }}"  class="w-full h-40 object-cover">
                        </div>
                        <div class="w-full md:w-3/4 p-4">
                            <h2 class="text-xl font-semibold">{{ $purchase->product->nama_barang }}</h2>
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                <div>
                                    <p class="text-gray-600">UKURAN</p>
                                    <p>{{ $purchase->size->size }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Jumlah</p>
                                    <p>{{ $purchase->quantity }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Selesai</span>
                                <div class="text-right">
                                    <p class="text-gray-600">Total harga</p>
                                    <p class="font-semibold">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('purchases.show', $purchase) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
</body>
<script>
    // Function to handle tab changing
    function changeTab(tabId) {
        // Hide all contents
        const contents = document.querySelectorAll('.tab-content');
        contents.forEach(content => {
            content.classList.add('hidden');
        });
        
        // Show selected content
        document.getElementById(`${tabId}-content`).classList.remove('hidden');
        
        // Update active tab styling
        const tabs = document.querySelectorAll('button[id$="-tab"]');
        tabs.forEach(tab => {
            tab.classList.remove('tab-active', 'border-indigo-500', 'text-indigo-600');
            tab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        });
        
        const activeTab = document.getElementById(`${tabId}-tab`);
        activeTab.classList.add('tab-active', 'border-indigo-500', 'text-indigo-600');
        activeTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    }
    
    // Auto-hide success message after 3 seconds
    setTimeout(function() {
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');
        if (successMessage) successMessage.style.display = 'none';
        if (errorMessage) errorMessage.style.display = 'none';
    }, 3000);
</script>
</html>
@endsection