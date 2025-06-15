@extends('layouts.app')

@section('title', 'Daftar Sebagai Delivery')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 to-amber-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Card -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full mb-4 shadow-lg">
                <i class="fas fa-truck text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Bergabung Sebagai Delivery</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Mulai karir Anda sebagai mitra delivery kami dan raih penghasilan yang menarik dengan jadwal kerja yang fleksibel</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-orange-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-user-plus mr-3"></i> 
                    Formulir Pendaftaran
                </h2>
                <p class="text-orange-100 mt-2">Lengkapi data diri Anda untuk memulai proses pendaftaran</p>
            </div>

            <div class="p-8">
                @if(session('warning'))
                    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-400 p-6 mb-8 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-500 text-lg"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-yellow-800 font-medium">{{ session('warning') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('delivery.register.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    <!-- Personal Information Section -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            Informasi Pribadi
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div class="md:col-span-2">
                                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-user mr-2 text-orange-500"></i> 
                                    Nama Lengkap 
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 hover:border-orange-300 @error('nama') border-red-500 ring-2 ring-red-200 @enderror" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama') }}" 
                                       placeholder="Masukkan nama lengkap Anda"
                                       required>
                                @error('nama')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-envelope mr-2 text-orange-500"></i> 
                                    Email 
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 hover:border-orange-300 @error('email') border-red-500 ring-2 ring-red-200 @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="contoh@email.com"
                                       required>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- No Telepon -->
                            <div>
                                <label for="no_telepon" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-phone mr-2 text-orange-500"></i> 
                                    No. Telepon 
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 hover:border-orange-300 @error('no_telepon') border-red-500 ring-2 ring-red-200 @enderror" 
                                       id="no_telepon" 
                                       name="no_telepon" 
                                       value="{{ old('no_telepon') }}" 
                                       placeholder="08xxxxxxxxxx"
                                       required>
                                @error('no_telepon')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Photo Upload Section -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-camera text-white text-sm"></i>
                            </div>
                            Foto Profil
                        </h3>
                        
                        <div class="space-y-4">
                            <label for="foto_profile" class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-image mr-2 text-orange-500"></i> 
                                Upload Foto Profil
                            </label>
                            
                            <div class="relative">
                                <input type="file" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 hover:border-orange-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 @error('foto_profile') border-red-500 ring-2 ring-red-200 @enderror" 
                                       id="foto_profile" 
                                       name="foto_profile" 
                                       accept="image/jpeg,image/png,image/jpg,image/gif">
                            </div>
                            
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-sm text-blue-700 flex items-start">
                                    <i class="fas fa-info-circle mr-2 mt-0.5 text-blue-500"></i> 
                                    <span>
                                        <strong>Ketentuan foto:</strong><br>
                                        • Format yang didukung: JPEG, PNG, JPG, GIF<br>
                                        • Ukuran maksimal: 2MB<br>
                                        • Gunakan foto yang jelas dan profesional
                                    </span>
                                </p>
                            </div>
                            
                            @error('foto_profile')
                                <p class="text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Preview Foto -->
                    <div class="hidden bg-gray-50 rounded-xl p-6 border border-gray-200" id="foto-preview">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-eye text-white text-sm"></i>
                            </div>
                            Preview Foto
                        </h3>
                        <div class="flex justify-center">
                            <div class="relative">
                                <img id="preview-image" src="" alt="Preview" class="w-48 h-48 object-cover rounded-xl shadow-lg border-4 border-white">
                                <div class="absolute -top-2 -right-2 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl p-6 border border-orange-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-clipboard-list text-white text-sm"></i>
                            </div>
                            Syarat dan Ketentuan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center mt-0.5">
                                    <i class="fas fa-motorcycle text-white text-xs"></i>
                                </div>
                                <span class="text-gray-700">Memiliki kendaraan sendiri (motor/mobil)</span>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center mt-0.5">
                                    <i class="fas fa-clock text-white text-xs"></i>
                                </div>
                                <span class="text-gray-700">Mampu bekerja dengan jadwal fleksibel</span>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center mt-0.5">
                                    <i class="fas fa-shield-alt text-white text-xs"></i>
                                </div>
                                <span class="text-gray-700">Bertanggung jawab atas keamanan barang</span>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center mt-0.5">
                                    <i class="fas fa-comments text-white text-xs"></i>
                                </div>
                                <span class="text-gray-700">Menjaga komunikasi baik dengan pelanggan</span>
                            </div>
                        </div>

                        <!-- Checkbox Agreement -->
                        <div class="flex items-start space-x-3 p-4 bg-white rounded-lg border border-orange-200">
                            <div class="flex items-center h-5">
                                <input id="agree" 
                                       name="agree" 
                                       type="checkbox" 
                                       class="w-5 h-5 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2" 
                                       required>
                            </div>
                            <label for="agree" class="text-sm text-gray-700">
                                Saya menyetujui semua <strong>syarat dan ketentuan</strong> yang berlaku sebagai mitra delivery 
                                <span class="text-red-500 font-semibold">*</span>
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ url()->previous() }}" 
                           class="flex-1 sm:flex-none px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-200 flex items-center justify-center border border-gray-300 hover:border-gray-400">
                            <i class="fas fa-arrow-left mr-2"></i> 
                            Kembali
                        </a>
                        <button type="submit" 
                                class="flex-1 px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i> 
                            Daftar Sebagai Delivery
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Additional Info Card -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6 border border-orange-100">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-orange-100 rounded-full mb-4">
                    <i class="fas fa-question-circle text-orange-500 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Butuh Bantuan?</h3>
                <p class="text-gray-600 mb-4">Tim support kami siap membantu Anda dalam proses pendaftaran</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium">
                        <i class="fas fa-phone mr-2"></i>
                        Hubungi Support
                    </a>
                    <a href="#" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium">
                        <i class="fas fa-envelope mr-2"></i>
                        Email Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview foto sebelum upload
document.getElementById('foto_profile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const previewContainer = document.getElementById('foto-preview');
    const previewImage = document.getElementById('preview-image');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
            previewContainer.scrollIntoView({ behavior: 'smooth' });
        }
        reader.readAsDataURL(file);
    } else {
        previewContainer.classList.add('hidden');
    }
});

// Validasi nomor telepon
document.getElementById('no_telepon').addEventListener('input', function(e) {
    let value = e.target.value;
    // Hanya izinkan angka dan tanda plus
    value = value.replace(/[^0-9+]/g, '');
    e.target.value = value;
});

// Smooth scroll untuk form submission
document.querySelector('form').addEventListener('submit', function(e) {
    // Jika ada error, scroll ke error pertama
    setTimeout(() => {
        const firstError = document.querySelector('.text-red-600');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }, 100);
});

// Enhanced file input feedback
document.getElementById('foto_profile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileName = file ? file.name : '';
    
    if (file) {
        // Validasi ukuran file (2MB = 2048KB)
        if (file.size > 2048 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB.');
            this.value = '';
            return;
        }
        
        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Tipe file tidak didukung! Gunakan JPEG, PNG, JPG, atau GIF.');
            this.value = '';
            return;
        }
    }
});
</script>
@endsection