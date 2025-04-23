@extends('layouts.admin')

@section('title', 'Product Management')

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
                    <h1 class="text-2xl font-semibold text-orange-600">Product Management</h1>
                    <!-- <a href="" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-md transition">Add New Product</a> -->
                </div>

            <!-- Search Bar -->
            <div class="mb-6">
                <div class="flex">
                    <input type="text" id="searchInput" placeholder="Search products by name..." class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <button id="searchButton" class="px-4 py-2 bg-orange-600 text-white rounded-r-md hover:bg-orange-700 transition">Search</button>
                </div>
            </div>

                <!-- Products Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            @if($product->gambar)
                                                <img src="{{ asset('storage/'.$product->gambar) }}" alt="{{ $product->nama_barang }}" class="h-10 w-10 rounded-md object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-md bg-orange-100 flex items-center justify-center">
                                                    <span class="text-orange-800 font-medium">{{ substr($product->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->nama_barang }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($product->description, 40) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('products.show', $product->id) }}" class="text-blue-600 hover:text-orange-900">View</a>
                                            <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No products found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="hidden mt-4 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-orange-500"></div>
                    <p class="mt-2 text-gray-600">Searching products...</p>
                </div>

                <!-- No Results Message -->
                <div id="noResultsMessage" class="hidden mt-4 text-center text-gray-500">
                    No products found matching your search.
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const productsTableBody = document.querySelector('tbody');
        const noResultsMessage = document.getElementById('noResultsMessage') || createNoResultsMessage();
        const loadingIndicator = document.getElementById('loadingIndicator') || createLoadingIndicator();
        const paginationContainer = document.querySelector('.mt-4');
        let originalTableContent = productsTableBody.innerHTML;
        let searchTimeout;
        let currentRequest = null; // Track current request

        // Create Loading Indicator if it doesn't exist
        function createLoadingIndicator() {
            const div = document.createElement('div');
            div.id = 'loadingIndicator';
            div.className = 'hidden mt-4 text-center';
            div.innerHTML = `
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-orange-500"></div>
                <p class="mt-2 text-gray-600">Searching products...</p>
            `;
            paginationContainer.parentNode.insertBefore(div, paginationContainer);
            return div;
        }

        // Create No Results Message if it doesn't exist
        function createNoResultsMessage() {
            const div = document.createElement('div');
            div.id = 'noResultsMessage';
            div.className = 'hidden mt-4 text-center text-gray-500';
            div.textContent = 'No products found matching your search.';
            paginationContainer.parentNode.insertBefore(div, paginationContainer);
            return div;
        }

        // Function to perform search
        function performSearch() {
            const searchTerm = searchInput.value.trim();
            
            // If search term is empty, restore original content
            if (searchTerm === '') {
                productsTableBody.innerHTML = originalTableContent;
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
            fetch(`/admin/products/search?query=${encodeURIComponent(searchTerm)}`, {
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
                if (data.products.length === 0) {
                    noResultsMessage.classList.remove('hidden');
                    productsTableBody.innerHTML = '';
                    return;
                }
                
                // Build table rows from results
                let tableContent = '';
                data.products.forEach(product => {
                    const imageHtml = product.gambar 
                        ? `<img src="/storage/${product.gambar}" alt="${product.nama_barang}" class="h-10 w-10 rounded-md object-cover">`
                        : `<div class="h-10 w-10 rounded-md bg-orange-100 flex items-center justify-center">
                            <span class="text-orange-800 font-medium">${product.nama_barang.substring(0, 1)}</span>
                        </div>`;
                    
                    tableContent += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${product.id}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="h-10 w-10 flex-shrink-0">
                                    ${imageHtml}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">${product.nama_barang}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${product.description ? product.description.substring(0, 40) + (product.description.length > 40 ? '...' : '') : ''}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="/products/${product.id}" class="text-orange-600 hover:text-orange-900">View</a>
                                    <form action="/products/${product.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                
                productsTableBody.innerHTML = tableContent;
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
        if (productsTableBody) {
            originalTableContent = productsTableBody.innerHTML;
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