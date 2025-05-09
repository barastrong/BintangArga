@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .container {
            max-width: 1400px;
    margin: 0 auto;
    }
    /* Custom Colors */
    .text-orange {
        color: #FF7200 !important;
    }
    
    .bg-orange {
        background-color: #FF7200 !important;
    }
    
    .bg-orange-soft {
        background-color: rgba(255, 114, 0, 0.12) !important;
    }
    
    .btn-outline-orange {
        color: #FF7200;
        border-color: #FF7200;
        transition: all 0.3s ease;
    }
    
    .btn-outline-orange:hover {
        background-color: #FF7200;
        color: white;
        box-shadow: 0 5px 15px rgba(255, 114, 0, 0.3);
        transform: translateY(-2px);
    }
    
    .btn-orange {
        background: linear-gradient(135deg, #FF8C00, #FF5F00);
        color: white;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(255, 114, 0, 0.3);
    }
    
    .btn-orange:hover {
        box-shadow: 0 6px 15px rgba(255, 114, 0, 0.4);
        transform: translateY(-2px);
        color: white;
    }
    
    /* Profile Photo */
    .profile-photo-container {
        position: relative;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        background: white;
    }
    
    .profile-photo-wrapper {
        width: 100%;
        height: 100%;
        overflow: hidden;
        border-radius: 50%;
        border: 4px solid rgba(255, 114, 0, 0.1);
    }
    
    .profile-photo-container:hover {
        box-shadow: 0 15px 30px rgba(255, 114, 0, 0.2);
        transform: translateY(-5px);
    }
    
    .profile-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .profile-photo-container:hover .profile-preview {
        transform: scale(1.05);
    }
    
    .profile-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8f9fa, #eaeaea);
        color: #ccc;
    }
    
    .upload-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(255, 114, 0, 0.9), rgba(255, 140, 0, 0.8));
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .profile-photo-container:hover .upload-overlay {
        opacity: 1;
    }
    
    .upload-button {
        color: white;
        cursor: pointer;
        font-size: 1.4rem;
    }
    
    /* Form Styling */
    .modern-input {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04);
        background-color: #f8f9fa;
        transition: box-shadow 0.3s, transform 0.2s;
    }
    
    .modern-input:focus-within {
        box-shadow: 0 0 0 3px rgba(255, 114, 0, 0.15);
        transform: translateY(-2px);
    }
    
    .form-control:focus {
        border-color: #FF7200;
        box-shadow: none;
    }
    
    .input-group-text {
        padding-left: 15px;
        padding-right: 15px;
        background-color: #f8f9fa;
    }
    
    /* Cards */
    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08) !important;
        transform: translateY(-5px);
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .card {
        animation: fadeIn 0.6s ease-out forwards;
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .profile-photo-container {
            width: 180px;
            height: 180px;
        }
    }
    
    @media (max-width: 576px) {
        .profile-photo-container {
            width: 150px;
            height: 150px;
        }
    }
</style>
<body>
<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            @include('sellers.partials.sidebar')
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Card Header with Modern Orange Accent -->
                <div class="card-header bg-white d-flex align-items-center py-4 border-0 position-relative">
                    <div class="position-absolute top-0 start-0 h-100" style="width: 5px; background: linear-gradient(to bottom, #FF8C00, #FF5F00);"></div>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3"">
                            <i class="fas fa-user-edit" style="color: #FF7200; font-size: 1.2rem;"></i>
                        </div>
                        <h4 class="mb-0 fw-bold text-dark">Edit Profil Penjual</h4>
                    </div>
                </div>
                
                <!-- Card Body -->
                <div class="card-body p-4 p-lg-5">
                    <!-- Alerts -->
                    @if (session('success'))
                        <div class="alert alert-success border-0 shadow-sm fade show mb-4 rounded-3" role="alert" style="background-color: rgba(40, 167, 69, 0.12);">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-white rounded-circle me-3 shadow-sm">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="text-success fw-medium">{{ session('success') }}</div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Profile Form -->
                    <form method="POST" action="{{ route('seller.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Profile Photo Section -->
                            <div class="col-lg-4 mb-5 mb-lg-0">
                                <div class="text-center">
                                    <div class="profile-photo-container mb-4 mx-auto">
                                        <div class="profile-photo-wrapper">
                                            @if($seller->foto_profil)
                                                <img src="{{ asset('storage/' . $seller->foto_profil) }}" class="profile-preview" id="profilePreview" alt="Foto Profil">
                                            @else
                                                <div class="profile-placeholder" id="profilePlaceholder">
                                                    <i class="fas fa-user fa-3x"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="upload-overlay">
                                            <label for="foto_profil" class="upload-button">
                                                <i class="fas fa-camera"></i>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="file-input-wrapper">
                                            <input type="file" class="form-control visually-hidden @error('foto_profil') is-invalid @enderror" id="foto_profil" name="foto_profil" hidden>
                                            <label for="foto_profil" class="btn btn-outline-orange btn-sm rounded-pill px-4 py-2 fw-medium">
                                                <i class="fas fa-upload me-2"></i> Unggah Foto
                                            </label>
                                            <div class="file-name small text-muted mt-2" id="fileName"></div>
                                        </div>
                                        @error('foto_profil')
                                            <div class="text-danger small mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Form Fields Section -->
                            <div class="col-lg-8">
                                <div class="mb-4">
                                    <label for="nama_penjual" class="form-label fw-medium mb-2">Nama Penjual</label>
                                    <div class="input-group modern-input">
                                        <span class="input-group-text border-0">
                                            <i class="fas fa-user text-orange"></i>
                                        </span>
                                        <input type="text" class="form-control border-0 ps-2 @error('nama_penjual') is-invalid @enderror" 
                                            id="nama_penjual" name="nama_penjual" 
                                            value="{{ old('nama_penjual', $seller->nama_penjual) }}" required>
                                    </div>
                                    @error('nama_penjual')
                                        <div class="text-danger small mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="email_penjual" class="form-label fw-medium mb-2">Email Penjual</label>
                                    <div class="input-group modern-input">
                                        <span class="input-group-text border-0">
                                            <i class="fas fa-envelope text-orange"></i>
                                        </span>
                                        <input type="email" class="form-control border-0 ps-2 @error('email_penjual') is-invalid @enderror" 
                                            id="email_penjual" name="email_penjual" 
                                            value="{{ old('email_penjual', $seller->email_penjual) }}" required>
                                    </div>
                                    @error('email_penjual')
                                        <div class="text-danger small mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="mt-5 text-end">
                                    <button type="submit" class="btn btn-orange rounded-pill px-5 py-2 fw-medium">
                                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile image preview
    const inputFile = document.getElementById('foto_profil');
    const previewImage = document.getElementById('profilePreview');
    const placeholderDiv = document.getElementById('profilePlaceholder');
    const fileNameDiv = document.getElementById('fileName');
    
    if (inputFile) {
        inputFile.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    if (previewImage) {
                        previewImage.src = reader.result;
                        previewImage.style.display = 'block';
                    }
                    
                    if (placeholderDiv) {
                        placeholderDiv.style.display = 'none';
                    }
                    
                    if (fileNameDiv) {
                        // Limit filename length for display
                        let displayName = file.name;
                        if (displayName.length > 20) {
                            displayName = displayName.substring(0, 17) + '...';
                        }
                        fileNameDiv.textContent = displayName;
                    }
                });
                
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Add smooth animations to form elements
    const formElements = document.querySelectorAll('.form-control, .btn');
    formElements.forEach((element, index) => {
        element.style.opacity = 0;
        element.style.animation = `fadeIn 0.4s ease-out ${0.1 + (index * 0.05)}s forwards`;
    });
});
</script>
</html>
@endsection