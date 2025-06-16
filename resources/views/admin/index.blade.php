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
                        <input type="text" id="searchInput" placeholder="Search users by name, email, or role..." class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <button id="searchButton" class="px-4 py-2 bg-orange-600 text-white rounded-r-md hover:bg-orange-700 transition">Search</button>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auth Method</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered On</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 user-row">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            @if($user->profile_image)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                                    <span class="text-orange-800 font-medium">{{ substr($user->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 user-name">
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 user-email">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full user-role
                                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($user->role ?? 'user') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 user-auth-method">
                                        @if($user->google_id)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <svg class="w-3 h-3 mr-1" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                                </svg>
                                                Google
                                            </span>
                                        @elseif($user->github_id)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"/>
                                                </svg>
                                                GitHub
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                                </svg>
                                                Email
                                            </span>
                                        @endif
                                    </td>
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
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">No users found</td>
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
                const roleClass = user.role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800';
                
                // Profile image HTML
                const profileImageHtml = user.profile_image 
                    ? `<img class="h-10 w-10 rounded-full object-cover" src="/storage/${user.profile_image}" alt="${user.name}">`
                    : `<div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                         <span class="text-orange-800 font-medium">${firstLetter}</span>
                       </div>`;
                
                // Auth method HTML
                let authMethodHtml = '';
                if (user.google_id) {
                    authMethodHtml = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <svg class="w-3 h-3 mr-1" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Google
                    </span>`;
                } else if (user.github_id) {
                    authMethodHtml = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"/>
                        </svg>
                        GitHub
                    </span>`;
                } else {
                    authMethodHtml = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                        Email
                    </span>`;
                }
                
                tableContent += `
                    <tr class="hover:bg-gray-50 user-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-10 w-10 flex-shrink-0">
                                ${profileImageHtml}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 user-name">
                                ${user.name}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 user-email">${user.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full user-role ${roleClass}">
                                ${user.role.charAt(0).toUpperCase() + user.role.slice(1)}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 user-auth-method">
                            ${authMethodHtml}
                        </td>
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