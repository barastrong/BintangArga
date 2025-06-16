    @extends('layouts.admin')

    @section('title', 'Delivery Detail')

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-orange-600">Delivery Detail</h1>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.deliveries') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Back to List
                            </a>
                            <form action="{{ route('admin.deliveries.delete', $delivery->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this delivery person? This will also affect their assigned deliveries.');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete Delivery
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Basic Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h2>
                            
                            <!-- Profile Picture -->
                            <div class="mb-4 text-center">
                                @if($delivery->foto_profile)
                                    <img class="mx-auto h-32 w-32 rounded-full object-cover border-4 border-orange-200" 
                                        src="{{ asset('storage/' . $delivery->foto_profile) }}" 
                                        alt="{{ $delivery->nama }}">
                                @else
                                    <div class="mx-auto h-32 w-32 rounded-full bg-orange-100 flex items-center justify-center border-4 border-orange-200">
                                        <span class="text-orange-800 font-bold text-4xl">{{ substr($delivery->nama, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">ID</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $delivery->id }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $delivery->nama }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $delivery->email }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Delivery Serial</label>
                                    <p class="mt-1">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            {{ $delivery->delivery_serial }}
                                        </span>
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Phone Number</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $delivery->no_telepon ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Account Information</h2>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Associated User</label>
                                    @if($delivery->user)
                                        <div class="mt-1">
                                            <p class="text-sm text-gray-900">{{ $delivery->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $delivery->user->email }}</p>
                                            <!-- <p class="text-xs text-gray-500">Role: {{ ucfirst($delivery->user->role) }}</p> -->
                                        </div>
                                    @else
                                        <p class="mt-1 text-sm text-gray-500">No associated user account</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Registration Date</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $delivery->created_at ? $delivery->created_at->format('F d, Y \a\t H:i') : 'Unknown' }}
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $delivery->updated_at ? $delivery->updated_at->format('F d, Y \a\t H:i') : 'Unknown' }}
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Total Deliveries</label>
                                    <p class="mt-1">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $delivery->purchases_count }} Deliveries
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Deliveries -->
                    @if($delivery->purchases->count() > 0)
                        <div class="mt-8">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Deliveries</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purchase ID</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seller</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($delivery->purchases->take(10) as $purchase)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    #{{ $purchase->id }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $purchase->user->name ?? 'Unknown' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $purchase->product->nama_barang ?? 'Unknown' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $purchase->seller->nama_penjual ?? 'Unknown' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    Rp {{ number_format($purchase->total_price, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($purchase->status_pengiriman == 'delivered') bg-green-100 text-green-800
                                                        @elseif($purchase->status_pengiriman == 'shipped') bg-blue-100 text-blue-800
                                                        @elseif($purchase->status_pengiriman == 'picked_up') bg-yellow-100 text-yellow-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                        {{ ucfirst($purchase->status_pengiriman ?? 'pending') }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $purchase->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('admin.purchases.view', $purchase->id) }}" class="text-orange-600 hover:text-orange-900">
                                                        View Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($delivery->purchases->count() > 10)
                                <div class="mt-4 text-center">
                                    <p class="text-sm text-gray-500">
                                        Showing 10 of {{ $delivery->purchases->count() }} total deliveries.
                                        <a href="{{ route('admin.purchases') }}?delivery_id={{ $delivery->id }}" class="text-orange-600 hover:text-orange-900">
                                            View all deliveries →
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="mt-8">
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8v2a1 1 0 01-1 1h-2a1 1 0 01-1-1V5a1 1 0 011-1h2a1 1 0 011 1z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No deliveries assigned</h3>
                                <p class="mt-1 text-sm text-gray-500">This delivery person has not been assigned to any deliveries yet.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Performance Statistics -->
                    @if($delivery->purchases->count() > 0)
                        <div class="mt-8">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Performance Statistics</h2>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-green-800">Terkirim</p>
                                            <p class="text-2xl font-semibold text-green-900">
                                                {{ $delivery->purchases->where('status_pengiriman', 'delivered')->count() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-blue-800">Mengirim Product</p>
                                            <p class="text-2xl font-semibold text-blue-900">
                                                {{ $delivery->purchases->where('status_pengiriman', 'shipped')->count() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-yellow-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-yellow-800">Mengambil Product</p>
                                            <p class="text-2xl font-semibold text-yellow-900">
                                                {{ $delivery->purchases->where('status_pengiriman', 'picked_up')->count() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-800">Total Revenue</p>
                                            <p class="text-lg font-semibold text-gray-900">
                                                Rp {{ number_format($delivery->purchases->where('status_pengiriman', 'delivered')->sum('total_price'), 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection