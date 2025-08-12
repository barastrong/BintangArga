@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <div class="flex items-center justify-center min-h-screen bg-white px-4 py-12">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-orange-100 p-8 sm:p-10 space-y-6">
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-orange-700 bg-orange-50 border border-orange-200 rounded-lg" role="alert">
                    <strong>Sukses!</strong> {{ session('success') }}
                </div>
            @endif
        <div class="text-center">
            <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-store text-2xl text-orange-600"></i>
            </div>
            <h2 class="text-3xl font-bold text-orange-600">Registrasi Penjual</h2>
            <p class="mt-2 text-sm text-gray-600">Lengkapi informasi untuk mendaftar sebagai penjual.</p>
        </div>

        <form method="POST" action="{{ route('seller.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="nama_penjual" class="block text-sm font-medium text-gray-700 mb-2">Nama Penjual</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-orange-400"></i>
                    </div>
                    <input 
                        id="nama_penjual" 
                        type="text" 
                        name="nama_penjual" 
                        value="{{ old('nama_penjual') }}" 
                        required 
                        placeholder="Masukkan nama penjual"
                        class="block w-full pl-10 pr-3 py-3 border-2 rounded-lg shadow-sm transition duration-150 ease-in-out
                               @error('nama_penjual')
                                   border-red-300 focus:ring-red-500 focus:border-red-500 bg-red-50
                               @else
                                   border-orange-200 focus:ring-orange-500 focus:border-orange-500 hover:border-orange-300
                               @enderror"
                    >
                </div>
                @error('nama_penjual')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email_penjual" class="block text-sm font-medium text-gray-700 mb-2">Email Penjual</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-orange-400"></i>
                    </div>
                    <input 
                        id="email_penjual" 
                        type="email" 
                        name="email_penjual" 
                        value="{{ old('email_penjual') }}" 
                        required 
                        placeholder="email@example.com"
                        class="block w-full pl-10 pr-3 py-3 border-2 rounded-lg shadow-sm transition duration-150 ease-in-out
                               @error('email_penjual')
                                   border-red-300 focus:ring-red-500 focus:border-red-500 bg-red-50
                               @else
                                   border-orange-200 focus:ring-orange-500 focus:border-orange-500 hover:border-orange-300
                               @enderror"
                    >
                </div>
                @error('email_penjual')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">No Telepon (Opsional)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-orange-400"></i>
                    </div>
                    <input 
                        id="no_telepon" 
                        type="text" 
                        name="no_telepon" 
                        value="{{ old('no_telepon') }}" 
                        placeholder="Masukkan nomor telepon"
                        class="block w-full pl-10 pr-3 py-3 border-2 rounded-lg shadow-sm transition duration-150 ease-in-out
                               @error('no_telepon')
                                   border-red-300 focus:ring-red-500 focus:border-red-500 bg-red-50
                               @else
                                   border-orange-200 focus:ring-orange-500 focus:border-orange-500 hover:border-orange-300
                               @enderror"
                    >
                </div>
                @error('no_telepon')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="foto_profil" class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                <div id="drag-drop-area" class="flex justify-center items-center flex-col px-6 pt-8 pb-8 border-2 border-dashed rounded-lg cursor-pointer transition-all duration-300
                    @error('foto_profil')
                        border-red-300 bg-red-50
                    @else
                        border-orange-300 hover:border-orange-400 hover:bg-orange-50
                    @enderror"
                >
                    <input type="file" id="foto_profil" name="foto_profil" accept=".jpg,.jpeg,.png,.gif" class="sr-only">
                    <div class="space-y-3 text-center">
                        <div class="mx-auto w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-cloud-upload-alt text-xl text-orange-500"></i>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p>Seret & lepas file atau <span class="font-medium text-orange-600 hover:text-orange-700 underline">klik untuk memilih</span></p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                    </div>
                </div>
                <div id="file-preview" class="mt-4 flex justify-center"></div>
                @error('foto_profil')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full flex justify-center items-center gap-3 py-4 px-6 border border-transparent rounded-lg shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-4 focus:ring-orange-300 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-xl">
                    <i class="fas fa-user-plus text-lg"></i>
                    Daftar Sebagai Penjual
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dragDropArea = document.getElementById('drag-drop-area');
    const fileInput = document.getElementById('foto_profil');
    const filePreview = document.getElementById('file-preview');

    // Prevent default browser behavior for drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dragDropArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
        }, false);
    });

    // Highlight the drop zone on drag enter/over
    ['dragenter', 'dragover'].forEach(eventName => {
        dragDropArea.addEventListener(eventName, () => {
            dragDropArea.classList.add('bg-orange-100', 'border-orange-500', 'scale-105');
        }, false);
    });

    // Unhighlight the drop zone on drag leave/drop
    ['dragleave', 'drop'].forEach(eventName => {
        dragDropArea.addEventListener(eventName, () => {
            dragDropArea.classList.remove('bg-orange-100', 'border-orange-500', 'scale-105');
        }, false);
    });

    // Trigger file input click when the area is clicked
    dragDropArea.addEventListener('click', () => fileInput.click());

    // Handle file drop
    dragDropArea.addEventListener('drop', e => {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        handleFiles(files);
    }, false);
    
    // Handle file selection from file input
    fileInput.addEventListener('change', e => {
        handleFiles(e.target.files);
    }, false);

    function handleFiles(files) {
        if (files.length === 0) {
            filePreview.innerHTML = '';
            return;
        }

        const file = files[0];
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Format file tidak valid. Harap unggah JPG, PNG, atau GIF.');
            fileInput.value = '';
            filePreview.innerHTML = '';
            return;
        }

        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            fileInput.value = '';
            filePreview.innerHTML = '';
            return;
        }

        // Generate and display preview
        const reader = new FileReader();
        reader.onload = function(e) {
            filePreview.innerHTML = `
                <div class="relative">
                    <img src="${e.target.result}" alt="Pratinjau File" class="max-h-48 rounded-lg object-cover shadow-lg border-2 border-orange-200">
                    <div class="absolute top-2 right-2 bg-orange-500 text-white rounded-full p-1">
                        <i class="fas fa-check text-xs"></i>
                    </div>
                </div>
            `;
        }
        reader.readAsDataURL(file);
    }
});
</script>
</body>
</html>
@endsection