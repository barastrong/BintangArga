<div class="bg-white rounded-xl shadow-md p-6 space-y-6">
    
    <!-- Bagian Profil Delivery -->
    <div class="flex flex-col items-center text-center border-b pb-6">
        @if(Auth::user()->delivery && Auth::user()->delivery->foto_profile)
            <img src="{{ asset('storage/' . Auth::user()->delivery->foto_profile) }}" 
                 alt="Profil Delivery" 
                 class="w-24 h-24 rounded-full object-cover border-4 border-orange-100">
        @elseif(Auth::user()->delivery)
            {{-- Fallback jika tidak ada foto profil --}}
            <span class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gradient-to-br from-orange-100 to-orange-200 border-4 border-orange-200">
                <span class="text-3xl font-medium leading-none bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent">
                    {{ substr(Auth::user()->delivery->nama, 0, 1) }}
                </span>
            </span>
        @else
            {{-- Default icon jika belum ada akun delivery --}}
            <span class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 border-4 border-gray-200">
                <i class="fas fa-truck text-3xl text-gray-400"></i>
            </span>
        @endif
        
        @if(Auth::user()->delivery)
            <h2 class="mt-3 text-lg font-bold text-gray-800">{{ Auth::user()->delivery->nama }}</h2>
            <p class="text-sm text-gray-500">{{ Auth::user()->delivery->email }}</p>
            <div class="mt-2 px-3 py-1 bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 text-xs font-medium rounded-full">
                ID: {{ Auth::user()->delivery->delivery_serial }}
            </div>
        @else
            <h2 class="mt-3 text-lg font-bold text-gray-800">Delivery Account</h2>
            <p class="text-sm text-gray-500">Belum terdaftar sebagai delivery</p>
        @endif
    </div>

    <!-- Bagian Menu Navigasi -->
    <nav class="space-y-2">
        <h3 class="px-3 text-xs font-semibold uppercase text-gray-500 tracking-wider">Menu</h3>

        @if(Auth::user()->delivery)
            {{-- Menu untuk delivery yang sudah terdaftar --}}
            <a href="{{ route('delivery.dashboard') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                      {{ request()->routeIs('delivery.dashboard') 
                         ? 'bg-gradient-to-r from-orange-100 to-orange-200 text-orange-700' 
                         : 'text-gray-600 hover:bg-gradient-to-r hover:from-orange-50 hover:to-orange-100 hover:text-orange-700' }}">
                <i class="fas fa-tachometer-alt w-6 text-center"></i>
                <span class="ml-3">Dashboard</span>
            </a>

            <a href="{{ route('delivery.orders') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                      {{ request()->routeIs('delivery.orders*') 
                         ? 'bg-gradient-to-r from-orange-100 to-orange-200 text-orange-700' 
                         : 'text-gray-600 hover:bg-gradient-to-r hover:from-orange-50 hover:to-orange-100 hover:text-orange-700' }}">
                <i class="fas fa-box w-6 text-center"></i>
                <span class="ml-3">Pesanan</span>
                @php
                    $pendingCount = App\Models\Purchase::where('delivery_id', Auth::user()->delivery->id)
                        ->where('status', 'shipping')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="ml-auto bg-gradient-to-r from-red-500 to-red-600 text-white text-xs rounded-full px-2 py-1 shadow-sm">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>

            <a href="{{ route('delivery.history') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                      {{ request()->routeIs('delivery.history') 
                         ? 'bg-gradient-to-r from-orange-100 to-orange-200 text-orange-700' 
                         : 'text-gray-600 hover:bg-gradient-to-r hover:from-orange-50 hover:to-orange-100 hover:text-orange-700' }}">
                <i class="fas fa-history w-6 text-center"></i>
                <span class="ml-3">Riwayat</span>
            </a>

            <a href="{{ route('delivery.profile') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                      {{ request()->routeIs('delivery.profile') || request()->routeIs('delivery.edit-profile')
                         ? 'bg-gradient-to-r from-orange-100 to-orange-200 text-orange-700' 
                         : 'text-gray-600 hover:bg-gradient-to-r hover:from-orange-50 hover:to-orange-100 hover:text-orange-700' }}">
                <i class="fas fa-user-cog w-6 text-center"></i>
                <span class="ml-3">Profil</span>
            </a>

        @else
            {{-- Menu untuk user yang belum terdaftar sebagai delivery --}}
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-orange-200 rounded-lg p-4 mb-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-orange-600 mr-2"></i>
                    <p class="text-sm text-orange-800">
                        Anda belum terdaftar sebagai delivery
                    </p>
                </div>
            </div>

            <a href="{{ route('delivery.register') }}" 
               class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors bg-gradient-to-r from-orange-500 to-orange-600 text-white hover:from-orange-600 hover:to-orange-700 shadow-sm">
                <i class="fas fa-user-plus w-6 text-center"></i>
                <span class="ml-3">Daftar Sebagai Delivery</span>
            </a>

            {{-- Menu yang tidak bisa diakses tanpa registrasi --}}
            <div class="opacity-50 cursor-not-allowed">
                <div class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-400">
                    <i class="fas fa-tachometer-alt w-6 text-center"></i>
                    <span class="ml-3">Dashboard</span>
                    <i class="fas fa-lock ml-auto text-xs"></i>
                </div>

                <div class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-400">
                    <i class="fas fa-box w-6 text-center"></i>
                    <span class="ml-3">Pesanan</span>
                    <i class="fas fa-lock ml-auto text-xs"></i>
                </div>

                <div class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-400">
                    <i class="fas fa-history w-6 text-center"></i>
                    <span class="ml-3">Riwayat</span>
                    <i class="fas fa-lock ml-auto text-xs"></i>
                </div>

                <div class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-400">
                    <i class="fas fa-user-cog w-6 text-center"></i>
                    <span class="ml-3">Edit Profil</span>
                    <i class="fas fa-lock ml-auto text-xs"></i>
                </div>
            </div>
        @endif
    </nav>

    @if(Auth::user()->delivery)
        <!-- Statistik Singkat -->
        <div class="border-t pt-4">
            <h3 class="px-3 text-xs font-semibold uppercase text-gray-500 tracking-wider mb-3">
                Statistik
            </h3>
            <div class="space-y-2">
                @php
                    $totalDeliveries = App\Models\Purchase::where('delivery_id', Auth::user()->delivery->id)->count();
                    $completedDeliveries = App\Models\Purchase::where('delivery_id', Auth::user()->delivery->id)
                        ->where('status_pengiriman', 'delivered')->count();
                @endphp
                
                <div class="flex justify-between items-center px-3 py-1">
                    <span class="text-xs text-gray-600">Total Pengiriman</span>
                    <span class="text-xs font-medium bg-gradient-to-r from-orange-600 to-orange-700 bg-clip-text text-transparent">{{ $totalDeliveries }}</span>
                </div>
                
                <div class="flex justify-between items-center px-3 py-1">
                    <span class="text-xs text-gray-600">Selesai</span>
                    <span class="text-xs font-medium bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">{{ $completedDeliveries }}</span>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal Konfirmasi untuk menu yang terkunci -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Jika user belum terdaftar sebagai delivery, tampilkan pesan saat mengklik menu terkunci
    @if(!Auth::user()->delivery)
        const lockedMenus = document.querySelectorAll('.opacity-50 .flex');
        lockedMenus.forEach(menu => {
            menu.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Anda perlu mendaftar sebagai delivery terlebih dahulu. Apakah ingin mendaftar sekarang?')) {
                    window.location.href = '{{ route("delivery.register") }}';
                }
            });
        });
    @endif
});
</script>