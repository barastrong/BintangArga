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
    
    <div class="flex items-center justify-center min-h-screen bg-gray-100 px-4 py-12">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-8 sm:p-10 space-y-6">
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg" role="alert">
                    <strong>Sukses!</strong> {{ session('success') }}
                </div>
            @endif
        <div class="text-center">
            <h2 class="text-3xl font-bold text-orange-500">Registrasi Penjual</h2>
            <p class="mt-2 text-sm text-gray-600">Lengkapi informasi untuk mendaftar sebagai penjual.</p>
        </div>

        <form method="POST" action="{{ route('seller.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="nama_penjual" class="block text-sm font-medium text-gray-700">Nama Penjual</label>
                <div class="mt-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input 
                        id="nama_penjual" 
                        type="text" 
                        name="nama_penjual" 
                        value="{{ old('nama_penjual') }}" 
                        required 
                        placeholder="Masukkan nama penjual"
                        class="block w-full pl-10 pr-3 py-2 border rounded-md shadow-sm transition duration-150 ease-in-out
                               @error('nama_penjual')
                                   border-red-500 focus:ring-red-500 focus:border-red-500
                               @else
                                   border-gray-300 focus:ring-orange-500 focus:border-orange-500
                               @enderror"
                    >
                </div>
                @error('nama_penjual')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email_penjual" class="block text-sm font-medium text-gray-700">Email Penjual</label>
                <div class="mt-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input 
                        id="email_penjual" 
                        type="email" 
                        name="email_penjual" 
                        value="{{ old('email_penjual') }}" 
                        required 
                        placeholder="email@example.com"
                        class="block w-full pl-10 pr-3 py-2 border rounded-md shadow-sm transition duration-150 ease-in-out
                               @error('email_penjual')
                                   border-red-500 focus:ring-red-500 focus:border-red-500
                               @else
                                   border-gray-300 focus:ring-orange-500 focus:border-orange-500
                               @enderror"
                    >
                </div>
                @error('email_penjual')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="no_telepon" class="block text-sm font-medium text-gray-700">No Telepon (Opsional)</label>
                <div class="mt-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-gray-400"></i>
                    </div>
                    <input 
                        id="no_telepon" 
                        type="text" 
                        name="no_telepon" 
                        value="{{ old('no_telepon') }}" 
                        placeholder="Masukkan nomor telepon"
                        class="block w-full pl-10 pr-3 py-2 border rounded-md shadow-sm transition duration-150 ease-in-out
                               @error('no_telepon')
                                   border-red-500 focus:ring-red-500 focus:border-red-500
                               @else
                                   border-gray-300 focus:ring-orange-500 focus:border-orange-500
                               @enderror"
                    >
                </div>
                @error('no_telepon')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

            <div>
                <label for="foto_profil" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                <div id="drag-drop-area" class="mt-1 flex justify-center items-center flex-col px-6 pt-5 pb-6 border-2 border-dashed rounded-md cursor-pointer transition-colors duration-300
                    @error('foto_profil')
                        border-red-400 bg-red-50
                    @else
                        border-gray-300 hover:border-orange-400 hover:bg-orange-50
                    @enderror"
                >
                    <input type="file" id="foto_profil" name="foto_profil" accept=".jpg,.jpeg,.png,.gif" class="sr-only">
                    <div class="space-y-1 text-center">
                        <i class="fas fa-cloud-upload-alt mx-auto h-12 w-12 text-gray-400"></i>
                        <div class="flex text-sm text-gray-600">
                            <p class="pl-1">Seret & lepas file atau <span class="font-medium text-orange-600 hover:text-orange-500">klik untuk memilih</span></p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                    </div>
                </div>
                <div id="file-preview" class="mt-4 flex justify-center"></div>
                @error('foto_profil')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                    <i class="fas fa-user-plus"></i>
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
            // Add Tailwind classes for highlighting
            dragDropArea.classList.add('bg-orange-100', 'border-orange-500');
        }, false);
    });

    // Unhighlight the drop zone on drag leave/drop
    ['dragleave', 'drop'].forEach(eventName => {
        dragDropArea.addEventListener(eventName, () => {
            // Remove Tailwind classes
            dragDropArea.classList.remove('bg-orange-100', 'border-orange-500');
        }, false);
    });

    // Trigger file input click when the area is clicked
    dragDropArea.addEventListener('click', () => fileInput.click());

    // Handle file drop
    dragDropArea.addEventListener('drop', e => {
        const dt = e.dataTransfer;
        const files = dt.files;
        // Assign dropped files to the file input
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
            fileInput.value = ''; // Clear the input
            filePreview.innerHTML = '';
            return;
        }

        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            fileInput.value = ''; // Clear the input
            filePreview.innerHTML = '';
            return;
        }

        // Generate and display preview
        const reader = new FileReader();
        reader.onload = function(e) {
            filePreview.innerHTML = `
                <img src="${e.target.result}" alt="Pratinjau File" class="max-h-48 rounded-lg object-cover shadow-md">
            `;
        }
        reader.readAsDataURL(file);
    }
});
</script>
</body>
</html>
@endsection