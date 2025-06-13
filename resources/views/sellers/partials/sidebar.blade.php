<div class="bg-white rounded-xl shadow-md p-6 space-y-6">
    
    <!-- Bagian Profil Penjual -->
    <div class="flex flex-col items-center text-center border-b pb-6">
        @if(Auth::user()->seller->foto_profil)
            <img src="{{ asset('storage/' . Auth::user()->seller->foto_profil) }}" alt="Profil Penjual" class="w-24 h-24 rounded-full object-cover border-4 border-orange-100">
        @else
            {{-- Fallback jika tidak ada foto profil --}}
            <span class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-orange-100 border-4 border-orange-200">
                <span class="text-3xl font-medium leading-none text-orange-600">{{ substr(Auth::user()->seller->nama_penjual, 0, 1) }}</span>
            </span>
        @endif
        <h2 class="mt-3 text-lg font-bold text-gray-800">{{ Auth::user()->seller->nama_penjual }}</h2>
        <p class="text-sm text-gray-500">{{ Auth::user()->seller->email_penjual }}</p>
    </div>

    <!-- Bagian Menu Navigasi -->
    <nav class="space-y-2">
        <h3 class="px-3 text-xs font-semibold uppercase text-gray-500 tracking-wider">Menu</h3>

        <a href="{{ route('seller.dashboard') }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                  {{ request()->routeIs('seller.dashboard') 
                     ? 'bg-orange-100 text-orange-700' 
                     : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <i class="fas fa-tachometer-alt w-6 text-center"></i>
            <span class="ml-3">Dashboard</span>
        </a>

        <a href="{{ route('seller.products') }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                  {{ request()->routeIs('seller.products*') 
                     ? 'bg-orange-100 text-orange-700' 
                     : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <i class="fas fa-box-open w-6 text-center"></i>
            <span class="ml-3">Produk Saya</span>
        </a>

        <a href="{{ route('seller.orders') }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                  {{ request()->routeIs('seller.orders*') 
                     ? 'bg-orange-100 text-orange-700' 
                     : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <i class="fas fa-receipt w-6 text-center"></i>
            <span class="ml-3">Pesanan</span>
        </a>

        <a href="{{ route('seller.edit') }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                  {{ request()->routeIs('seller.edit') 
                     ? 'bg-orange-100 text-orange-700' 
                     : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <i class="fas fa-user-cog w-6 text-center"></i>
            <span class="ml-3">Edit Profil</span>
        </a>
    </nav>
</div>