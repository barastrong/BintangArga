@extends('layouts.admin')

@section('title', 'Delivery Management')

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
                    <h1 class="text-2xl font-semibold text-orange-600">Delivery Management</h1>
                </div>

                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="flex">
                        <input type="text" id="searchInput" placeholder="Search deliveries by name, email, serial number..." class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <button id="searchButton" class="px-4 py-2 bg-orange-600 text-white rounded-r-md hover:bg-orange-700 transition">Search</button>
                    </div>
                </div>

                <!-- Deliveries Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deliveries</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered On</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="deliveriesTableBody" class="bg-white divide-y divide-gray-200">
                            @forelse($deliveries as $delivery)
                                <tr class="hover:bg-gray-50 delivery-row">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $delivery->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            @if($delivery->foto_profile)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $delivery->foto_profile) }}" alt="{{ $delivery->nama }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                                    <span class="text-orange-800 font-medium">{{ substr($delivery->nama, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 delivery-name">
                                            {{ $delivery->nama }}
                                        </div>
                                        @if($delivery->user)
                                            <div class="text-xs text-gray-500">
                                                User: {{ $delivery->user->name }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 delivery-email">{{ $delivery->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 delivery-serial">
                                            {{ $delivery->delivery_serial }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 delivery-phone">
                                        {{ $delivery->no_telepon ?? 'Not provided' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $delivery->purchases_count }} Deliveries
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $delivery->created_at ? $delivery->created_at->format('M d, Y') : 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.deliveries.view', $delivery->id) }}" class="text-orange-600 hover:text-orange-900">View</a>
                                            <form action="{{ route('admin.deliveries.delete', $delivery->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this delivery person? This will also affect their assigned deliveries.');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="empty-table-row">
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">No deliveries found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="hidden mt-4 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-orange-500"></div>
                    <p class="mt-2 text-gray-600">Searching all deliveries...</p>
                </div>

                <!-- No Results Message -->
                <div id="noResultsMessage" class="hidden mt-4 text-center text-gray-500">
                    No deliveries found matching your search.
                </div>

                <!-- Pagination (Only visible when not searching) -->
                <div id="paginationContainer" class="mt-4">
                    {{ $deliveries->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const deliveriesTableBody = document.getElementById('deliveriesTableBody');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const paginationContainer = document.getElementById('paginationContainer');
    let originalTableContent = deliveriesTableBody.innerHTML;
    let searchTimeout;
    let currentRequest = null;

    // Function to perform search
    function performSearch() {
        const searchTerm = searchInput.value.trim();
        
        // If search term is empty, restore original content
        if (searchTerm === '') {
            deliveriesTableBody.innerHTML = originalTableContent;
            if (noResultsMessage) noResultsMessage.classList.add('hidden');
            if (paginationContainer) paginationContainer.classList.remove('hidden');
            return;
        }
        
        // Show loading indicator
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        if (noResultsMessage) noResultsMessage.classList.add('hidden');
        if (paginationContainer) paginationContainer.classList.add('hidden');
        
        // Cancel any ongoing request
        if (currentRequest) {
            currentRequest.abort();
        }
        
        // Create new AbortController for this request
        const controller = new AbortController();
        currentRequest = controller;
        
        // Make AJAX request to search
        fetch(`/admin/deliveries/search?query=${encodeURIComponent(searchTerm)}`, {
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
            if (loadingIndicator) loadingIndicator.classList.add('hidden');
            
            // If no results, show message
            if (data.deliveries.length === 0) {
                if (noResultsMessage) noResultsMessage.classList.remove('hidden');
                deliveriesTableBody.innerHTML = '';
                return;
            }
            
            // Build table rows from results
            let tableContent = '';
            data.deliveries.forEach(delivery => {
                const firstLetter = delivery.nama ? delivery.nama.substring(0, 1) : '?';
                
                // Profile image HTML
                const profileImageHtml = delivery.foto_profile 
                    ? `<img class="h-10 w-10 rounded-full object-cover" src="/storage/${delivery.foto_profile}" alt="${delivery.nama}">`
                    : `<div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                         <span class="text-orange-800 font-medium">${firstLetter}</span>
                       </div>`;
                
                const userInfo = delivery.user_name ? `<div class="text-xs text-gray-500">User: ${delivery.user_name}</div>` : '';
                
                tableContent += `
                    <tr class="hover:bg-gray-50 delivery-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${delivery.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-10 w-10 flex-shrink-0">
                                ${profileImageHtml}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 delivery-name">
                                ${delivery.nama}
                            </div>
                            ${userInfo}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 delivery-email">${delivery.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 delivery-serial">
                                ${delivery.delivery_serial}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 delivery-phone">
                            ${delivery.no_telepon || 'Not provided'}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                ${delivery.purchases_count} Deliveries
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${delivery.created_at_formatted}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="/admin/deliveries/${delivery.id}" class="text-orange-600 hover:text-orange-900">View</a>
                                <form action="/admin/deliveries/${delivery.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this delivery person? This will also affect their assigned deliveries.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            deliveriesTableBody.innerHTML = tableContent;
        })
        .catch(error => {
            // Don't show error for aborted requests
            if (error.name !== 'AbortError') {
                console.error('Search error:', error);
                if (loadingIndicator) loadingIndicator.classList.add('hidden');
                // Show a more user-friendly error message
                alert('Search could not be completed. Please try again.');
            }
        })
        .finally(() => {
            currentRequest = null;
        });
    }

    // Save original table content on page load
    if (deliveriesTableBody) {
        originalTableContent = deliveriesTableBody.innerHTML;
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