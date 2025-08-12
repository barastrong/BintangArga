@extends('layouts.admin')

@section('title', 'Seller Approvals')

@section('content')
<div class="py-12 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-green-100">
            <div class="p-6 bg-white border-b border-green-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-green-600">Seller Approvals</h1>
                    <div class="flex space-x-3">
                        <span class="px-4 py-2 text-sm font-semibold bg-yellow-100 text-yellow-800 rounded-full shadow-sm">
                            Pending: {{ $sellers->where('is_proved', 0)->count() }}
                        </span>
                        <span class="px-4 py-2 text-sm font-semibold bg-green-100 text-green-800 rounded-full shadow-sm">
                            Approved: {{ $sellers->where('is_proved', 1)->count() }}
                        </span>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex">
                        <input type="text" id="searchInput" placeholder="Search by shop name, email, serial number..." 
                               class="flex-1 px-4 py-3 border border-green-200 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                        <button id="searchButton" class="px-6 py-3 bg-green-600 text-white rounded-r-lg hover:bg-green-700 transition-colors duration-200 font-medium shadow-sm">
                            Search
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto bg-white rounded-lg shadow-sm border border-green-100">
                    <table class="min-w-full divide-y divide-green-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Profile</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Shop Name</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Serial</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Phone</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Products</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Joined</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sellersTableBody" class="bg-white divide-y divide-green-100">
                            @forelse($sellers as $seller)
                                <tr class="hover:bg-green-25 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-12 w-12 flex-shrink-0">
                                            @if($seller->foto_profil)
                                                <img class="h-12 w-12 rounded-full object-cover border-2 border-green-200" src="{{ asset('storage/' . $seller->foto_profil) }}" alt="{{ $seller->nama_penjual }}">
                                            @else
                                                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center border-2 border-green-200">
                                                    <span class="text-green-700 font-semibold text-lg">{{ substr($seller->nama_penjual, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $seller->nama_penjual}}</div>
                                        @if($seller->user)
                                            <div class="text-xs text-green-600">User: {{ $seller->user->name }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $seller->email_penjual }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            {{ $seller->nomor_seri }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $seller->no_telepon ?? 'Not provided' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($seller->is_proved)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-50 text-green-700 border border-green-200">
                                            {{ $seller->products_count }} Products
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $seller->created_at ? $seller->created_at->format('M d, Y') : 'Unknown' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if($seller->is_proved)
                                                <form action="{{ route('admin.approvals.seller.reject', $seller->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors duration-200 font-medium" onclick="return confirm('Are you sure you want to revoke approval?')">Revoke</button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.approvals.seller.approve', $seller->id) }}" method="POST" class="inline">
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
                                            <svg class="w-12 h-12 text-green-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            <p class="text-gray-500">No sellers found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div id="loadingIndicator" class="hidden mt-6 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-green-500"></div>
                    <p class="mt-3 text-gray-600 font-medium">Searching sellers...</p>
                </div>

                <div id="noResultsMessage" class="hidden mt-6 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-16 h-16 text-green-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <p class="text-lg font-medium">No sellers found matching your search.</p>
                    </div>
                </div>

                <div id="paginationContainer" class="mt-6">
                    {{ $sellers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const sellersTableBody = document.getElementById('sellersTableBody');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const paginationContainer = document.getElementById('paginationContainer');
    let originalTableContent = sellersTableBody.innerHTML;
    let searchTimeout;
    let currentRequest = null;

    function performSearch() {
        const searchTerm = searchInput.value.trim();
        
        if (searchTerm === '') {
            sellersTableBody.innerHTML = originalTableContent;
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
        
        fetch(`/admin/approvals/sellers/search?query=${encodeURIComponent(searchTerm)}`, {
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
            
            if (data.sellers.length === 0) {
                if (noResultsMessage) noResultsMessage.classList.remove('hidden');
                sellersTableBody.innerHTML = '';
                return;
            }
            
            let tableContent = '';
            data.sellers.forEach(seller => {
                const firstLetter = seller.nama_toko ? seller.nama_toko.substring(0, 1) : '?';
                
                const profileImageHtml = seller.foto_profile 
                    ? `<img class="h-12 w-12 rounded-full object-cover border-2 border-green-200" src="/storage/${seller.foto_profile}" alt="${seller.nama_toko}">`
                    : `<div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center border-2 border-green-200">
                         <span class="text-green-700 font-semibold text-lg">${firstLetter}</span>
                       </div>`;
                
                const userInfo = seller.user_name ? `<div class="text-xs text-green-600">User: ${seller.user_name}</div>` : '';
                const statusHtml = seller.is_proved ? 
                    '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>' :
                    '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>';
                
                const actionHtml = seller.is_proved ?
                    `<form action="/admin/approvals/seller/${seller.id}/reject" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors duration-200 font-medium" onclick="return confirm('Are you sure you want to revoke approval?')">Revoke</button>
                     </form>` :
                    `<form action="/admin/approvals/seller/${seller.id}/approve" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-md transition-colors duration-200 font-medium">Approve</button>
                     </form>`;
                
                tableContent += `
                    <tr class="hover:bg-green-25 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-12 w-12 flex-shrink-0">
                                ${profileImageHtml}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">${seller.nama_toko}</div>
                            ${userInfo}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${seller.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                ${seller.seller_serial}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${seller.no_telepon || 'Not provided'}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${statusHtml}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-50 text-green-700 border border-green-200">
                                ${seller.products_count} Products
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${seller.created_at_formatted}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                ${actionHtml}
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            sellersTableBody.innerHTML = tableContent;
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

    if (sellersTableBody) {
        originalTableContent = sellersTableBody.innerHTML;
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