@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-6">
            <!-- Sidebar -->
            <div class="w-64 flex-shrink-0">
                @include('delivery.partials.sidebar')
            </div>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Header -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Edit Profil</h1>
                            <p class="text-gray-600 mt-1">Perbarui informasi profil delivery Anda</p>
                        </div>
                        <a href="{{ route('delivery.profile') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Edit Form -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <form action="{{ route('delivery.update-profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Photo Upload Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Foto Profil</h3>
                            <div class="flex items-center space-x-6">
                                <!-- Current Photo -->
                                <div class="flex-shrink-0">
                                    @if($delivery->foto_profile)
                                        <img id="current-photo" 
                                             src="{{ asset('storage/' . $delivery->foto_profile) }}" 
                                             alt="Profil Delivery" 
                                             class="w-24 h-24 rounded-full object-cover border-4 border-gray-200">
                                    @else
                                        <span id="current-photo" 
                                              class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 border-4 border-gray-200">
                                            <span class="text-2xl font-medium leading-none text-gray-600">
                                                {{ substr($delivery->nama, 0, 1) }}
                                            </span>
                                        </span>
                                    @endif
                                </div>

                                <!-- Upload Button -->
                                <div class="flex-1">
                                    <div class="relative">
                                        <input type="file" 
                                               name="foto_profile" 
                                               id="foto_profile"
                                               accept="image/jpeg,image/png,image/jpg,image/gif"
                                               class="hidden"
                                               onchange="previewImage(this)">
                                        <label for="foto_profile" 
                                               class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                                            <i class="fas fa-camera mr-2"></i>
                                            Ubah Foto
                                        </label>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-2">
                                        Format: JPG, PNG, GIF. Maksimal 2MB.
                                    </p>
                                    @error('foto_profile')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nama" 
                                       id="nama"
                                       value="{{ old('nama', $delivery->nama) }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror"
                                       placeholder="Masukkan nama lengkap">
                                @error('nama')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email"
                                       value="{{ old('email', $delivery->email) }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                       placeholder="Masukkan email">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No Telepon -->
                            <div>
                                <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                    No. Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="tel"
                                name="no_telepon" 
                                       id="no_telepon"
                                       value="{{ old('no_telepon', $delivery->no_telepon) }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_telepon') border-red-500 @enderror"
                                       placeholder="Masukkan nomor telepon">
                                @error('no_telepon')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tambahan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Tanggal Bergabung -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Bergabung
                                    </label>
                                    <div class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-gray-600">
                                        {{ $delivery->created_at->format('d F Y') }}
                                    </div>
                                </div>

                                <!-- Total Pengiriman -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Total Pengiriman Selesai
                                    </label>
                                    <div class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-gray-600">
                                        {{ $delivery->purchases()->where('status_pengiriman', 'delivered')->count() }} pesanan
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('delivery.profile') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            const currentPhoto = document.getElementById('current-photo');
            
            if (currentPhoto.tagName === 'IMG') {
                currentPhoto.src = e.target.result;
            } else {
                // Replace span with img
                const img = document.createElement('img');
                img.id = 'current-photo';
                img.src = e.target.result;
                img.alt = 'Profil Delivery';
                img.className = 'w-24 h-24 rounded-full object-cover border-4 border-gray-200';
                currentPhoto.parentNode.replaceChild(img, currentPhoto);
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection