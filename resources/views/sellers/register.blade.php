@extends('layouts.app')

@section('content')
<div class="bg-gray-50 flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Daftar Sebagai Penjual
            </h2>
            {{-- [REVISI] Ukuran teks diperbesar --}}
            <p class="mt-2 text-center text-base text-gray-600">
                Lengkapi informasi di bawah untuk membuka tokomu.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8 space-y-6">
            <form method="POST" action="{{ route('seller.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Nama Penjual -->
                <div>
                    {{-- [REVISI] Ukuran teks label diperbesar --}}
                    <label for="nama_penjual" class="block text-base font-medium text-gray-700">Nama Toko / Penjual</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        {{-- [REVISI] Padding dan ukuran teks input diperbesar --}}
                        <input type="text" name="nama_penjual" id="nama_penjual" value="{{ old('nama_penjual') }}" required 
                               class="w-full pl-12 px-4 py-3 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                               placeholder="Contoh: Bintang Store">
                    </div>
                    @error('nama_penjual') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email Penjual -->
                <div>
                    <label for="email_penjual" class="block text-base font-medium text-gray-700">Email Kontak Toko</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email_penjual" id="email_penjual" value="{{ old('email_penjual') }}" required 
                               class="w-full pl-12 px-4 py-3 border border-gray-300 rounded-md text-base focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                               placeholder="email@toko.com">
                    </div>
                    @error('email_penjual') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Upload Foto Profil -->
                <div>
                    <label class="block text-base font-medium text-gray-700">Foto Profil / Logo Toko (Opsional)</label>
                    <div id="drag-drop-area" class="mt-2 flex justify-center px-6 py-10 border-2 border-gray-300 border-dashed rounded-md cursor-pointer hover:border-orange-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <div id="file-preview" class="hidden mb-4">
                                {{-- Preview akan dimasukkan oleh JS --}}
                            </div>
                            <div id="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt mx-auto h-12 w-12 text-gray-400"></i>
                                {{-- [REVISI] Ukuran teks diperbesar --}}
                                <div class="flex text-base text-gray-600">
                                    <label for="foto_profil" class="relative font-medium text-orange-600 hover:text-orange-500">
                                        <span>Unggah file</span>
                                        <input id="foto_profil" name="foto_profil" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">atau seret dan lepas</p>
                                </div>
                                <p class="text-sm text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                            </div>
                        </div>
                    </div>
                    @error('foto_profil') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    {{-- [REVISI] Ukuran tombol dan teks diperbesar --}}
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-base font-medium rounded-md text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script tidak perlu diubah --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dragDropArea = document.getElementById('drag-drop-area');
        const fileInput = document.getElementById('foto_profil');
        const filePreview = document.getElementById('file-preview');
        const uploadPlaceholder = document.getElementById('upload-placeholder');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dragDropArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dragDropArea.addEventListener(eventName, () => dragDropArea.classList.add('bg-orange-50'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dragDropArea.addEventListener(eventName, () => dragDropArea.classList.remove('bg-orange-50'), false);
        });

        dragDropArea.addEventListener('click', () => fileInput.click());
        dragDropArea.addEventListener('drop', handleDrop, false);
        fileInput.addEventListener('change', (e) => handleFiles(e.target.files), false);

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function handleDrop(e) {
            handleFiles(e.dataTransfer.files);
        }

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('Hanya file JPG, PNG, atau GIF yang diperbolehkan');
                    return;
                }

                if (file.size > 2 * 1024 * 1024) { // 2MB
                    alert('Ukuran file maksimal 2MB');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    filePreview.innerHTML = `<img src="${e.target.result}" alt="File Preview" class="mx-auto h-24 w-24 rounded-full object-cover">`;
                    filePreview.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    });
</script>
@endsection