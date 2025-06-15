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
                            <h1 class="text-2xl font-bold text-gray-900">Profil Delivery</h1>
                            <p class="text-gray-600 mt-1">Kelola informasi profil Anda</p>
                        </div>
                        <a href="{{ route('delivery.edit-profile') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Profil
                        </a>
                    </div>
                </div>

                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <!-- Cover Photo -->
                    <div class="h-32 bg-gradient-to-r from-blue-500 to-purple-600"></div>
                    
                    <!-- Profile Info -->
                    <div class="relative px-6 pb-6">
                        <!-- Profile Picture -->
                        <div class="flex items-center -mt-16 mb-6">
                            @if($delivery->foto_profile)
                                <img src="{{ asset('storage/' . $delivery->foto_profile) }}" 
                                     alt="Profil Delivery" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                            @else
                                <span class="inline-flex items-center justify-center h-32 w-32 rounded-full bg-gray-100 border-4 border-white shadow-lg">
                                    <span class="text-4xl font-medium leading-none text-gray-600">
                                        {{ substr($delivery->nama, 0, 1) }}
                                    </span>
                                </span>
                            @endif
                            <div class="ml-6">
                                <h2 class="text-2xl font-bold text-gray-900">{{ $delivery->nama }}</h2>
                                <p class="text-gray-600">Delivery Partner</p>
                                <div class="mt-2 flex items-center space-x-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                        ID: {{ $delivery->delivery_serial }}
                                    </span>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Verified
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    <i class="fas fa-user mr-2 text-blue-600"></i>
                                    Informasi Personal
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                                        <p class="mt-1 text-gray-900">{{ $delivery->nama }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600">Email</label>
                                        <p class="mt-1 text-gray-900">{{ $delivery->email }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600">No. Telepon</label>
                                        <p class="mt-1 text-gray-900">{{ $delivery->no_telepon }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600">Tanggal Bergabung</label>
                                        <p class="mt-1 text-gray-900">{{ $delivery->created_at->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    <i class="fas fa-chart-bar mr-2 text-green-600"></i>
                                    Statistik Pengiriman
                                </h3>
                                @php
                                    $totalDeliveries = App\Models\Purchase::where('delivery_id', $delivery->id)->count();
                                    $completedDeliveries = App\Models\Purchase::where('delivery_id', $delivery->id)
                                        ->where('status_pengiriman', 'delivered')->count();
                                    $pendingDeliveries = App\Models\Purchase::where('delivery_id', $delivery->id)
                                        ->whereIn('status_pengiriman', ['pending', 'picked_up', 'shipping'])->count();
                                    $successRate = $totalDeliveries > 0 ? round(($completedDeliveries / $totalDeliveries) * 100, 1) : 0;
                                @endphp
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center bg-white rounded-lg p-4">
                                        <div class="text-2xl font-bold text-blue-600">{{ $totalDeliveries }}</div>
                                        <div class="text-sm text-gray-600">Total Pengiriman</div>
                                    </div>
                                    <div class="text-center bg-white rounded-lg p-4">
                                        <div class="text-2xl font-bold text-green-600">{{ $completedDeliveries }}</div>
                                        <div class="text-sm text-gray-600">Selesai</div>
                                    </div>
                                    <div class="text-center bg-white rounded-lg p-4">
                                        <div class="text-2xl font-bold text-orange-600">{{ $pendingDeliveries }}</div>
                                        <div class="text-sm text-gray-600">Dalam Proses</div>
                                    </div>
                                    <div class="text-center bg-white rounded-lg p-4">
                                        <div class="text-2xl font-bold text-purple-600">{{ $successRate }}%</div>
                                        <div class="text-sm text-gray-600">Success Rate</div>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mt-4">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Progress Pengiriman</span>
                                        <span>{{ $successRate }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2 rounded-full transition-all duration-300" 
                                             style="width: {{ $successRate }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="mt-6 bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-clock mr-2 text-purple-600"></i>
                                Aktivitas Terakhir
                            </h3>
                            @php
                                $recentOrders = App\Models\Purchase::with(['product', 'user'])
                                    ->where('delivery_id', $delivery->id)
                                    ->orderBy('updated_at', 'desc')
                                    ->take(5)
                                    ->get();
                            @endphp

                            @if($recentOrders->count() > 0)
                                <div class="space-y-3">
                                    @foreach($recentOrders as $order)
                                        <div class="flex items-center justify-between bg-white rounded-lg p-3">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-box text-blue-600 text-sm"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ Str::limit($order->product->nama_produk, 30) }}
                                                    </p>
                                                    <p class="text-xs text-gray-600">
                                                        {{ $order->updated_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                            @php
                                                $statusConfig = [
                                                    'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Pending'],
                                                    'picked_up' => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'Picked Up'],
                                                    'shipping' => ['class' => 'bg-purple-100 text-purple-800', 'text' => 'Shipping'],
                                                    'delivered' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Delivered']
                                                ];
                                                $currentStatus = $statusConfig[$order->status_pengiriman] ?? ['class' => 'bg-gray-100 text-gray-800', 'text' => 'Unknown'];
                                            @endphp
                                            <span class="px-2 py-1 text-xs font-medium rounded {{ $currentStatus['class'] }}">
                                                {{ $currentStatus['text'] }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-history text-gray-400 text-3xl mb-3"></i>
                                    <p class="text-gray-500">Belum ada aktivitas pengiriman</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Now on the right) -->
            <div class="w-64 flex-shrink-0">
                @include('delivery.partials.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection