```php
@extends('layouts.admin')

@section('title', 'Purchase Details')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-4">
            <a href="{{ route('admin.purchases') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Purchases
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-orange-600">Purchase Details</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.purchases') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md transition">
                            Cancel
                        </a>
                        <form action="{{ route('admin.purchases.delete', $purchase->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this purchase?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Purchase Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Purchase Information</h2>
                        
                        <div class="mb-4">
                            <div class="text-sm font-medium text-gray-500">Purchase ID</div>
                            <div class="text-lg font-semibold">#{{ $purchase->id }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="text-sm font-medium text-gray-500">Date</div>
                            <div>{{ $purchase->created_at->format('F d, Y h:i A') }}</div>
                        </div>

                        <div class="mb-4">
                            <div class="text-sm font-medium text-gray-500">Order Status</div>
                            <div>
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($purchase->status == 'pending') bg-yellow-100 text-yellow-800 
                                    @elseif($purchase->status == 'process') bg-blue-100 text-blue-800 
                                    @elseif($purchase->status == 'completed') bg-green-100 text-green-800 
                                    @elseif($purchase->status == 'cancelled') bg-red-100 text-red-800 
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="text-sm font-medium text-gray-500">Payment Status</div>
                            <div>
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($purchase->payment_status == 'pending') bg-yellow-100 text-yellow-800 
                                    @elseif($purchase->payment_status == 'paid') bg-green-100 text-green-800 
                                    @elseif($purchase->payment_status == 'failed') bg-red-100 text-red-800 
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($purchase->payment_status) }}
                                </span>
                            </div>
                        </div>
                        
                        @if($purchase->status_pembelian)
                        <div class="mb-4">
                            <div class="text-sm font-medium text-gray-500">Purchase Status</div>
                            <div>{{ $purchase->status_pembelian }}</div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Customer Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h2>
                        
                        <div class="mb-4">
                            <div class="text-sm font-medium text-gray-500">Customer Name</div>
                            <div>{{ $purchase->user->name ?? 'Unknown' }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="text-sm font-medium text-gray-500">Email</div>
                            <div>{{ $purchase->user->email ?? 'Unknown' }}</div>
                        </div>

                        <div class="mb-4">
                            <div class="text-sm font-medium text-gray-500">Customer Since</div>
                            <div>{{ $purchase->user->created_at ? $purchase->user->created_at->format('F d, Y') : 'Unknown' }}</div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('admin.users.view', $purchase->user->id ?? 0) }}" class="text-blue-600 hover:underline">
                                View Customer Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Product Information</h2>
                    
                    <div class="flex flex-col md:flex-row md:space-x-6">
                        @if($purchase->product && $purchase->product->gambar)
                        <div class="w-full md:w-1/4 mb-4 md:mb-0">
                            <img src="{{ asset('storage/' . $purchase->product->gambar) }}" 
                                alt="{{ $purchase->product->nama_barang ?? 'Product Image' }}" 
                                class="w-full h-auto object-cover rounded-lg shadow-sm">
                        </div>
                        @endif
                        
                        <div class="w-full md:w-3/4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Product Name</div>
                                    <div class="font-medium">{{ $purchase->product->nama_barang ?? 'Unknown Product' }}</div>
                                </div>
                                
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Size</div>
                                    <div>{{ $purchase->size->size ?? 'N/A' }}</div>
                                </div>
                                
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Quantity</div>
                                    <div>{{ $purchase->quantity }}</div>
                                </div>
                                
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Price Per Item</div>
                                    <div>Rp {{ number_format($purchase->total_price / $purchase->quantity, 0, ',', '.') }}</div>
                                </div>
                                
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Total Price</div>
                                    <div class="text-lg font-semibold text-orange-600">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            
                            @if($purchase->product && $purchase->product->description)
                            <div class="mt-4">
                                <div class="text-sm font-medium text-gray-500">Product Description</div>
                                <div class="mt-1 text-sm text-gray-700">{{ $purchase->product->description }}</div>
                            </div>
                            @endif
                            <div class="mt-4">
                                <a href="{{ route('products.show', $purchase->product->id) }}" class="text-blue-600 hover:underline">
                                    View Product Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seller Information (if applicable) -->
                @if($purchase->seller)
                <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Seller Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Seller Name</div>
                            <div>{{ $purchase->seller->nama_penjual ?? 'Unknown Seller' }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500">Seller Email</div>
                            <div>{{ $purchase->seller->email_penjual ?? 'Unknown' }}</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Additional Information -->
                <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- You can add more additional purchase information here as needed -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Created At</div>
                            <div>{{ $purchase->created_at->format('F d, Y h:i A') }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500">Last Updated</div>
                            <div>{{ $purchase->updated_at->format('F d, Y h:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```