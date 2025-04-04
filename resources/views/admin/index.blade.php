@extends('layouts.admin')

@section('title', 'User Management')

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
                    <h1 class="text-2xl font-semibold text-orange-600">User Management</h1>
                </div>

                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="flex">
                        <input type="text" id="searchInput" placeholder="Search users by name or email..." class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <button id="searchButton" class="px-4 py-2 bg-orange-600 text-white rounded-r-md hover:bg-orange-700 transition">Search</button>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered On</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 user-row">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                                    <span class="text-orange-800 font-medium">{{ substr($user->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 user-name">
                                                    {{ $user->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 user-email">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at ? $user->created_at->format('M d, Y') : 'Kosong' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.users.view', $user->id) }}" class="text-orange-600 hover:text-orange-900">View</a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="empty-table-row">
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="hidden mt-4 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-orange-500"></div>
                    <p class="mt-2 text-gray-600">Searching all users...</p>
                </div>

                <!-- No Results Message -->
                <div id="noResultsMessage" class="hidden mt-4 text-center text-gray-500">
                    No users found matching your search.
                </div>

                <!-- Pagination (Only visible when not searching) -->
                <div id="paginationContainer" class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Add this JavaScript to your view file
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const usersTableBody = document.getElementById('usersTableBody');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const paginationContainer = document.getElementById('paginationContainer');
    let originalTableContent = usersTableBody.innerHTML;
    let searchTimeout;
    let currentRequest = null; // Track current request

    // Function to perform search
    function performSearch() {
        const searchTerm = searchInput.value.trim();
        
        // If search term is empty, restore original content
        if (searchTerm === '') {
            usersTableBody.innerHTML = originalTableContent;
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
        fetch(`/admin/users/search?query=${encodeURIComponent(searchTerm)}`, {
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
            if (data.users.length === 0) {
                if (noResultsMessage) noResultsMessage.classList.remove('hidden');
                usersTableBody.innerHTML = '';
                return;
            }
            
            // Build table rows from results
            let tableContent = '';
            data.users.forEach(user => {
                const firstLetter = user.name ? user.name.substring(0, 1) : '?';
                
                tableContent += `
                    <tr class="hover:bg-gray-50 user-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                        <span class="text-orange-800 font-medium">${firstLetter}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 user-name">
                                        ${user.name}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 user-email">${user.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${user.created_at_formatted}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="/admin/users/${user.id}" class="text-orange-600 hover:text-orange-900">View</a>
                                <a href="/admin/users/${user.id}/edit" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="/admin/users/${user.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            usersTableBody.innerHTML = tableContent;
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
    if (usersTableBody) {
        originalTableContent = usersTableBody.innerHTML;
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