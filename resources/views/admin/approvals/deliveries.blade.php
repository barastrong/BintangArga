@extends('layouts.admin')

@section('title', 'Delivery Approvals')

@section('content')
<div class="py-12 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-orange-50 border-l-4 border-orange-500 text-orange-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-orange-100">
            <div class="p-6 bg-white border-b border-orange-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-orange-600">Delivery Approvals</h1>
                    <div class="flex space-x-3">
                        <span class="px-4 py-2 text-sm font-semibold bg-orange-100 text-orange-800 rounded-full shadow-sm">
                            Pending: {{ $deliveries->where('is_proved', 0)->count() }}
                        </span>
                        <span class="px-4 py-2 text-sm font-semibold bg-green-100 text-green-800 rounded-full shadow-sm">
                            Approved: {{ $deliveries->where('is_proved', 1)->count() }}
                        </span>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex">
                        <input type="text" id="searchInput" placeholder="Search by name, email, serial number..." 
                               class="flex-1 px-4 py-3 border border-orange-200 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white">
                        <button id="searchButton" class="px-6 py-3 bg-orange-600 text-white rounded-r-lg hover:bg-orange-700 transition-colors duration-200 font-medium shadow-sm">
                            Search
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto bg-white rounded-lg shadow-sm border border-orange-100">
                    <table class="min-w-full divide-y divide-orange-200">
                        <thead class="bg-orange-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-orange-700 uppercase tracking-wider">Profile</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-orange-700 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-orange-700 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-orange-700 uppercase tracking-wider">Serial</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-orange-700 uppercase tracking-wider">Phone</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-orange-700 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-orange-700 uppercase tracking-wider">Deliveries</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-orange-700 uppercase tracking-wider">Joined</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-orange-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="deliveriesTableBody" class="bg-white divide-y divide-orange-100">
                            @forelse($deliveries as $delivery)
                                <tr class="hover:bg-orange-25 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-12 w-12 flex-shrink-0">
                                            @if($delivery->foto_profile)
                                                <img class="h-12 w-12 rounded-full object-cover border-2 border-orange-200" src="{{ asset('storage/' . $delivery->foto_profile) }}" alt="{{ $delivery->nama }}">
                                            @else
                                                <div class="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center border-2 border-orange-200">
                                                    <span class="text-orange-700 font-semibold text-lg">{{ substr($delivery->nama, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $delivery->nama }}</div>
                                        @if($delivery->user)
                                            <div class="text-xs text-orange-600">User: {{ $delivery->user->name }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $delivery->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                            {{ $delivery->delivery_serial }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $delivery->no_telepon ?? 'Not provided' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($delivery->is_proved)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-50 text-orange-700 border border-orange-200">
                                            {{ $delivery->purchases_count }} Orders
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $delivery->created_at ? $delivery->created_at->format('M d, Y') : 'Unknown' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if($delivery->is_proved)
                                                <form action="{{ route('admin.approvals.delivery.reject', $delivery->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors duration-200 font-medium" onclick="return confirm('Are you sure you want to revoke approval?')">Revoke</button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.approvals.delivery.approve', $delivery->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-md transition-colors duration-200 font-medium">Approve</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="empty-table-row">
                                    <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-orange-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8l-3 3m0 0l-3-3m3 3V4"></path>
                                            </svg>
                                            <p class="text-gray-500">No deliveries found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div id="loadingIndicator" class="hidden mt-6 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-orange-500"></div>
                    <p class="mt-3 text-gray-600 font-medium">Searching deliveries...</p>
                </div>

                <div id="noResultsMessage" class="hidden mt-6 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-16 h-16 text-orange-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.464-.881-6.08-2.33C7.76 11.53 9.785 11 12 11s4.24.53 6.08 1.67A7.96 7.96 0 0118 13.291z"></path>
                        </svg>
                        <p class="text-lg font-medium">No deliveries found matching your search.</p>
                    </div>
                </div>

                <div id="paginationContainer" class="mt-6">
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

    function performSearch() {
        const searchTerm = searchInput.value.trim();
        
        if (searchTerm === '') {
            deliveriesTableBody.innerHTML = originalTableContent;
            if (noResultsMessage) noResultsMessage.classList.add('hidden');
            if (paginationContainer) paginationContainer.classList.remove('hidden');
            return;
        }
        
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        if (noResultsMessage) noResultsMessage.classList.add('hidden');
        if (paginationContainer) paginationContainer.classList.add('hidden');
        
        if (currentRequest) {
            currentRequest.abort();
        }
        
        const controller = new AbortController();
        currentRequest = controller;
        
        fetch(`/admin/approvals/deliveries/search?query=${encodeURIComponent(searchTerm)}`, {
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
            if (loadingIndicator) loadingIndicator.classList.add('hidden');
            
            if (data.deliveries.length === 0) {
                if (noResultsMessage) noResultsMessage.classList.remove('hidden');
                deliveriesTableBody.innerHTML = '';
                return;
            }
            
            let tableContent = '';
            data.deliveries.forEach(delivery => {
                const firstLetter = delivery.nama ? delivery.nama.substring(0, 1) : '?';
                
                const profileImageHtml = delivery.foto_profile 
                    ? `<img class="h-12 w-12 rounded-full object-cover border-2 border-orange-200" src="/storage/${delivery.foto_profile}" alt="${delivery.nama}">`
                    : `<div class="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center border-2 border-orange-200">
                         <span class="text-orange-700 font-semibold text-lg">${firstLetter}</span>
                       </div>`;
                
                const userInfo = delivery.user_name ? `<div class="text-xs text-orange-600">User: ${delivery.user_name}</div>` : '';
                const statusHtml = delivery.is_proved ? 
                    '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>' :
                    '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Pending</span>';
                
                const actionHtml = delivery.is_proved ?
                    `<form action="/admin/approvals/delivery/${delivery.id}/reject" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors duration-200 font-medium" onclick="return confirm('Are you sure you want to revoke approval?')">Revoke</button>
                     </form>` :
                    `<form action="/admin/approvals/delivery/${delivery.id}/approve" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-md transition-colors duration-200 font-medium">Approve</button>
                     </form>`;
                
                tableContent += `
                    <tr class="hover:bg-orange-25 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-12 w-12 flex-shrink-0">
                                ${profileImageHtml}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">${delivery.nama}</div>
                            ${userInfo}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${delivery.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                ${delivery.delivery_serial}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${delivery.no_telepon || 'Not provided'}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${statusHtml}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-50 text-orange-700 border border-orange-200">
                                ${delivery.purchases_count} Orders
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${delivery.created_at_formatted}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                ${actionHtml}
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            deliveriesTableBody.innerHTML = tableContent;
        })
        .catch(error => {
            if (error.name !== 'AbortError') {
                console.error('Search error:', error);
                if (loadingIndicator) loadingIndicator.classList.add('hidden');
                alert('Search could not be completed. Please try again.');
            }
        })
        .finally(() => {
            currentRequest = null;
        });
    }

    if (deliveriesTableBody) {
        originalTableContent = deliveriesTableBody.innerHTML;
    }

    if (searchButton) {
        searchButton.addEventListener('click', function(e) {
            e.preventDefault();
            performSearch();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 300);
        });

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