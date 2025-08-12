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
    /* Styling untuk tab aktif */
    .tab-active {
        border-color: #f97316; /* Orange-500 */
        color: #ea580c; /* Orange-600 */
    }
</style>
<body>
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Status Pesanan Saya</h1>

        <!-- Navigasi Tab yang Disesuaikan -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-6 overflow-x-auto" aria-label="Tabs">
                {{-- Nama tab disesuaikan dengan alur yang benar --}}
                <button onclick="changeTab('pending')" id="pending-tab" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Menunggu Konfirmasi
                </button>
                <button onclick="changeTab('diproses')" id="diproses-tab" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Diproses
                </button>
                <button onclick="changeTab('dikirim')" id="dikirim-tab" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Dikirim
                </button>
                <button onclick="changeTab('selesai')" id="selesai-tab" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Selesai
                </button>
                <button onclick="changeTab('cancelled')" id="cancelled-tab" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Dibatalkan
                </button>
            </nav>
        </div>

        <div class="mt-8">
            @php
                $statuses = ['pending', 'diproses', 'dikirim', 'selesai', 'cancelled'];
                $statusLabels = [
                    'pending' => [
                        'label' => 'Menunggu Konfirmasi',
                        'color' => 'bg-yellow-100 text-yellow-800'
                    ],
                    'diproses' => [
                        'label' => 'Sedang Diproses',
                        'color' => 'bg-orange-100 text-orange-800'
                    ],
                    'dikirim' => [
                        'label' => 'Sedang Dikirim',
                        'color' => 'bg-blue-100 text-blue-800'
                    ],
                    'selesai' => [
                        'label' => 'Pesanan Selesai',
                        'color' => 'bg-green-100 text-green-800'
                    ],
                    'cancelled' => [
                        'label' => 'Pesanan Dibatalkan',
                        'color' => 'bg-red-100 text-red-800'
                    ]
                ];
                $statusAliases = [
                    'process' => 'diproses',
                    'completed' => 'selesai',
                    'canceled' => 'cancelled'
                ];
            @endphp

            @foreach ($statuses as $status)
            <div id="{{ $status }}-content" class="tab-content hidden">
                @php
                    $filteredPurchases = $purchases->filter(function ($purchase) use ($status, $statusAliases) {
                        $currentStatus = $purchase->status;
                        $normalizedStatus = $statusAliases[$currentStatus] ?? $currentStatus;
                        return $normalizedStatus === $status;
                    });
                @endphp

                @if($filteredPurchases->isEmpty())
                    <div class="text-center py-16 px-6 bg-white rounded-lg shadow-sm">
                        <i class="fas fa-box-open text-5xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium text-gray-600">
                            Tidak ada pesanan dengan status "{{ $statusLabels[$status]['label'] }}".
                        </p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($filteredPurchases as $purchase)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="p-6">
                                <!-- Header Kartu Pesanan -->
                                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 border-b pb-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Nomor Pesanan</p>
                                        <p class="font-semibold text-gray-800">#{{ $purchase->id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal Pesanan</p>
                                        <p class="font-semibold text-gray-800">{{ $purchase->created_at->format('d F Y') }}</p>
                                    </div>
                                    <div class="text-left sm:text-right">
                                        <p class="text-sm text-gray-500">Total Pembayaran</p>
                                        <p class="font-bold text-lg text-orange-600">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                                <!-- Detail Item -->
                                <div class="flex gap-4">
                                    <img src="{{ asset('storage/' . $purchase->size->gambar_size) }}" alt="{{ $purchase->product->nama_barang }}" class="w-24 h-24 rounded-lg object-cover">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800">{{ $purchase->product->nama_barang }}</h3>
                                        <p class="text-sm text-gray-500">Ukuran: {{ $purchase->size->size }}</p>
                                        <p class="text-sm text-gray-500">Jumlah: {{ $purchase->quantity }}</p>
                                    </div>
                                    <div class="flex flex-col items-end justify-between">
                                        @php
                                            $currentStatus = $purchase->status;
                                            $normalizedStatus = $statusAliases[$currentStatus] ?? $currentStatus;
                                            $statusInfo = $statusLabels[$normalizedStatus] ?? ['label' => ucfirst($currentStatus), 'color' => 'bg-gray-100 text-gray-800'];
                                        @endphp
                                        <span class="{{ $statusInfo['color'] }} text-xs font-medium px-3 py-1 rounded-full">
                                            {{ $statusInfo['label'] }}
                                        </span>
                                        
                                        <div class="flex items-center gap-2 mt-4">
                                            <a href="{{ route('purchases.show', $purchase) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Lihat Detail</a>
                                            
                                            {{-- Tombol Batalkan hanya muncul jika status 'pending' --}}
                                            @if($purchase->status == 'pending')
                                                <form action="{{ route('purchases.cancel', $purchase) }}" method="POST" onsubmit="return confirm('Anda yakin ingin membatalkan pesanan ini?')">
                                                    @csrf
                                                    <button type="submit" class="bg-red-100 text-red-700 font-semibold py-1 px-3 rounded-md text-xs hover:bg-red-200">Batalkan</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

</body>
<script>
    function changeTab(tabId) {
        // Sembunyikan semua tab content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Tampilkan tab content yang dipilih
        document.getElementById(`${tabId}-content`).classList.remove('hidden');
        
        // Reset semua tab button
        document.querySelectorAll('.tab-button').forEach(tab => {
            tab.classList.remove('tab-active', 'border-orange-500', 'text-orange-600');
            tab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        });
        
        // Aktifkan tab yang dipilih
        const activeTab = document.getElementById(`${tabId}-tab`);
        activeTab.classList.add('tab-active', 'border-orange-500', 'text-orange-600');
        activeTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Set tab awal
        const initialTab = window.location.hash.substring(1) || 'pending';
        changeTab(initialTab);

        // Event listener untuk tab buttons
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.id.replace('-tab', '');
                window.location.hash = tabId;
            });
        });

        // Auto hide success/error messages
        setTimeout(function() {
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');
            if (successMessage) successMessage.style.display = 'none';
            if (errorMessage) errorMessage.style.display = 'none';
        }, 3000);
    });
</script>
</html>
@endsection