@extends('layouts.admin')

@section('title', 'Purchase Management')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-orange-600">Purchase Management</h1>
                </div>

                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="flex">
                        <input type="text" id="searchInput" placeholder="Search purchases by order ID, customer name, product name, or status..." class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <button id="searchButton" class="px-4 py-2 bg-orange-600 text-white rounded-r-md hover:bg-orange-700 transition">Search</button>
                    </div>
                </div>

                <!-- Purchases Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($purchases as $index => $purchase)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $purchase->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $purchase->user->name ?? 'Unknown' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $purchase->product->nama_barang ?? 'Unknown' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $purchase->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($purchase->status == 'pending') bg-yellow-100 text-yellow-800 
                                            @elseif($purchase->status == 'process') bg-blue-100 text-blue-800 
                                            @elseif($purchase->status == 'keranjang') bg-orange-100 text-orange-800 
                                            @elseif($purchase->status == 'completed') bg-green-100 text-green-800 
                                            @elseif($purchase->status == 'selesai') bg-green-100 text-green-800 
                                            @elseif($purchase->status == 'cancelled') bg-red-100 text-red-800 
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($purchase->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($purchase->payment_status == 'unpaid') bg-yellow-100 text-yellow-800 
                                            @elseif($purchase->payment_status == 'paid') bg-green-100 text-green-800 
                                            @elseif($purchase->payment_status == 'failed') bg-red-100 text-red-800 
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($purchase->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.purchases.view', $purchase->id) }}" class="text-blue-600 hover:text-orange-900">View</a>
                                            <form action="{{ route('admin.purchases.delete', $purchase->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this purchase?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">No purchases found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="hidden mt-4 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-orange-500"></div>
                    <p class="mt-2 text-gray-600">Searching purchases...</p>
                </div>

                <!-- No Results Message -->
                <div id="noResultsMessage" class="hidden mt-4 text-center text-gray-500">
                    No purchases found matching your search.
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $purchases->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const purchasesTableBody = document.querySelector('tbody');
        const noResultsMessage = document.getElementById('noResultsMessage') || createNoResultsMessage();
        const loadingIndicator = document.getElementById('loadingIndicator') || createLoadingIndicator();
        const paginationContainer = document.querySelector('.mt-4');
        let originalTableContent = purchasesTableBody.innerHTML;
        let searchTimeout;
        let currentRequest = null; // Track current request

        // Create Loading Indicator if it doesn't exist
        function createLoadingIndicator() {
            const div = document.createElement('div');
            div.id = 'loadingIndicator';
            div.className = 'hidden mt-4 text-center';
            div.innerHTML = `
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-orange-500"></div>
                <p class="mt-2 text-gray-600">Searching purchases...</p>
            `;
            paginationContainer.parentNode.insertBefore(div, paginationContainer);
            return div;
        }

        // Create No Results Message if it doesn't exist
        function createNoResultsMessage() {
            const div = document.createElement('div');
            div.id = 'noResultsMessage';
            div.className = 'hidden mt-4 text-center text-gray-500';
            div.textContent = 'No purchases found matching your search.';
            paginationContainer.parentNode.insertBefore(div, paginationContainer);
            return div;
        }

        // Function to perform search
        function performSearch() {
            const searchTerm = searchInput.value.trim();
            
            // If search term is empty, restore original content
            if (searchTerm === '') {
                purchasesTableBody.innerHTML = originalTableContent;
                noResultsMessage.classList.add('hidden');
                paginationContainer.classList.remove('hidden');
                return;
            }
            
            // Show loading indicator
            loadingIndicator.classList.remove('hidden');
            noResultsMessage.classList.add('hidden');
            paginationContainer.classList.add('hidden');
            
            // Cancel any ongoing request
            if (currentRequest) {
                currentRequest.abort();
            }
            
            // Create new AbortController for this request
            const controller = new AbortController();
            currentRequest = controller;
            
            // Make AJAX request to search
            fetch(`/admin/purchases/search?query=${encodeURIComponent(searchTerm)}`, {
                signal: controller.signal,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Hide loading indicator
                loadingIndicator.classList.add('hidden');
                
                // If no results, show message
                if (data.purchases.length === 0) {
                    noResultsMessage.classList.remove('hidden');
                    purchasesTableBody.innerHTML = '';
                    return;
                }
                
                // Build table rows from results
                let tableContent = '';
                data.purchases.forEach(purchase => {
                    // Determine status class
                    let statusClass = '';
                    if (purchase.status === 'pending') statusClass = 'bg-yellow-100 text-yellow-800';
                    else if (purchase.status === 'processing') statusClass = 'bg-blue-100 text-blue-800';
                    else if (purchase.status === 'shipped') statusClass = 'bg-indigo-100 text-indigo-800';
                    else if (purchase.status === 'delivered') statusClass = 'bg-green-100 text-green-800';
                    else if (purchase.status === 'cancelled') statusClass = 'bg-red-100 text-red-800';
                    else statusClass = 'bg-gray-100 text-gray-800';

                    // Determine payment status class
                    let paymentStatusClass = '';
                    if (purchase.payment_status === 'pending') paymentStatusClass = 'bg-yellow-100 text-yellow-800';
                    else if (purchase.payment_status === 'paid') paymentStatusClass = 'bg-green-100 text-green-800';
                    else if (purchase.payment_status === 'failed') paymentStatusClass = 'bg-red-100 text-red-800';
                    else paymentStatusClass = 'bg-gray-100 text-gray-800';
                    
                    tableContent += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${purchase.id}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">${purchase.user_name}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">${purchase.product_name}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${purchase.quantity}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp ${new Intl.NumberFormat('id-ID').format(purchase.total_price)}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                                    ${purchase.status.charAt(0).toUpperCase() + purchase.status.slice(1)}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${paymentStatusClass}">
                                    ${purchase.payment_status.charAt(0).toUpperCase() + purchase.payment_status.slice(1)}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="/admin/purchases/${purchase.id}" class="text-blue-600 hover:text-orange-900">View</a>
                                    <a href="/admin/purchases/${purchase.id}/edit" class="text-green-600 hover:text-green-900">Edit</a>
                                    <form action="/admin/purchases/${purchase.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this purchase?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                
                purchasesTableBody.innerHTML = tableContent;
            })
            .catch(error => {
                // Don't show error for aborted requests
                if (error.name !== 'AbortError') {
                    console.error('Search error:', error);
                    loadingIndicator.classList.add('hidden');
                    // Show a more user-friendly error message
                    alert('Search could not be completed. Please try again.');
                }
            })
            .finally(() => {
                currentRequest = null;
            });
        }

        // Save original table content on page load
        if (purchasesTableBody) {
            originalTableContent = purchasesTableBody.innerHTML;
        }

        // Event listener for search button
        if (searchButton) {
            searchButton.addEventListener('click', function(e) {
                e.preventDefault();
                performSearch();
            });
        }

        // Event listener for search input (with debounce)
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 300); // 300ms debounce
            });

            // Event listener for Enter key
            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    clearTimeout(searchTimeout);
                    performSearch();
                }
            });
        }
    });
</script>
@endsection