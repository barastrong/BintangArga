@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Penjual</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f7f9fa;
    }

    .registration-container {
        width: 100%;
        max-width: 500px;
        background-color: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        padding: 40px;
        position: relative;
        overflow: hidden;
        margin-left: 37%
    }

    .registration-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .registration-title {
        font-size: 24px;
        font-weight: 700;
        color: #FF6B35;
        margin-bottom: 10px;
    }

    .registration-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #FF6B35;
        opacity: 0.7;
    }

    .form-input {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #FF6B35;
        box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
    }

    .drag-drop-area {
        border: 2px dashed #FF6B35;
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        background-color: #fff9f5;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .drag-drop-area.dragover {
        background-color: #fff3e0;
        border-color: #FF9800;
    }

    .upload-icon {
        color: #FF6B35;
        font-size: 48px;
        margin-bottom: 15px;
    }

    .submit-btn {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #FF6B35, #FF9800);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.4s ease;
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(255, 107, 53, 0.3);
    }

    .file-preview {
        margin-top: 15px;
        display: flex;
        justify-content: center;
    }

    .file-preview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 12px;
        object-fit: cover;
    }

    .error-message {
        color: #FF6B35;
        font-size: 13px;
        margin-top: 5px;
    }
</style>

<body>
    <div class="registration-container">
        <div class="registration-header">
            <h2 class="registration-title">Registrasi Penjual</h2>
            <p class="registration-subtitle">Lengkapi informasi untuk mendaftar sebagai penjual</p>
        </div>

        <form method="POST" action="{{ route('seller.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nama_penjual" class="form-label">Nama Penjual</label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input 
                        id="nama_penjual" 
                        type="text" 
                        class="form-input @error('nama_penjual') is-invalid @enderror" 
                        name="nama_penjual" 
                        value="{{ old('nama_penjual') }}" 
                        required 
                        placeholder="Masukkan nama penjual"
                    >
                </div>
                @error('nama_penjual')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email_penjual" class="form-label">Email Penjual</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input 
                        id="email_penjual" 
                        type="email" 
                        class="form-input @error('email_penjual') is-invalid @enderror" 
                        name="email_penjual" 
                        value="{{ old('email_penjual') }}" 
                        required 
                        placeholder="email@example.com"
                    >
                </div>
                @error('email_penjual')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="foto_profil" class="form-label">Foto Profil</label>
                <div id="drag-drop-area" class="drag-drop-area">
                    <input 
                        type="file" 
                        id="foto_profil" 
                        name="foto_profil" 
                        accept=".jpg,.jpeg,.png,.gif" 
                        style="display:none;"
                    >
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <p>Seret & lepas file di sini atau klik untuk memilih</p>
                    <small>Format: JPG, PNG, atau GIF (Maks: 2MB)</small>
                </div>
                <div id="file-preview" class="file-preview"></div>
                @error('foto_profil')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="submit-btn">
                    <i class="fas fa-user-plus me-2"></i> Daftar Sebagai Penjual
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dragDropArea = document.getElementById('drag-drop-area');
            const fileInput = document.getElementById('foto_profil');
            const filePreview = document.getElementById('file-preview');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dragDropArea.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dragDropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dragDropArea.addEventListener(eventName, unhighlight, false);
            });

            dragDropArea.addEventListener('click', () => fileInput.click());
            dragDropArea.addEventListener('drop', handleDrop, false);
            fileInput.addEventListener('change', handleFiles, false);

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight() {
                dragDropArea.classList.add('dragover');
            }

            function unhighlight() {
                dragDropArea.classList.remove('dragover');
            }

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles(files);
            }

            function handleFiles(files) {
                files = files.target ? files.target.files : files;
                
                if (files.length > 0) {
                    const file = files[0];
                    
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Hanya file JPG, PNG, atau GIF yang diperbolehkan');
                        return;
                    }

                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file maksimal 2MB');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        filePreview.innerHTML = `<img src="${e.target.result}" alt="File Preview">`;
                    }
                    reader.readAsDataURL(file);
                }
            }
        });
    </script>
</body>
</html>
@endsection