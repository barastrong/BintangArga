@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<style>
    :root {
        --orange-primary: #ff7a00;
        --orange-secondary: #ff9c40;
        --orange-light: #fff8f3;
        --light-gray: #f8f9fa;
        --border-color: #e9ecef;
    }
    
    body {
        background-color: #f5f5f5;
        font-family: 'Inter', sans-serif;
        margin: 0;
        padding: 0;
    }

    a{
        text-decoration: none;
    }
    .bg-orange {
        background-color: var(--orange-primary) !important;
    }
    
    .text-orange {
        color: var(--orange-primary) !important;
    }
    
    .border-orange {
        border-color: var(--orange-primary) !important;
    }
    
    .btn-orange {
        background-color: var(--orange-primary);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-orange:hover {
        background-color: var(--orange-secondary);
        transform: translateY(-2px);
    }
    
    .progress-container {
        margin-bottom: 40px;
    }
    
    .progress-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-top: 30px;
    }
    
    .progress-line {
        position: absolute;
        top: 25px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #e9ecef;
        z-index: 1;
    }
    
    .progress-line-active {
        position: absolute;
        top: 25px;
        left: 0;
        height: 2px;
        background-color: var(--orange-primary);
        z-index: 2;
        width: 33%;
    }
    
    .step {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: white;
        border: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        position: relative;
        z-index: 3;
    }
    
    .step.active {
        background-color: var(--orange-primary);
        border-color: var(--orange-primary);
        color: white;
    }
    
    .step.completed {
        background-color: var(--orange-primary);
        border-color: var(--orange-primary);
        color: white;
    }
    
    .step-label {
        position: absolute;
        top: 60px;
        font-size: 14px;
        font-weight: 500;
        color: #6c757d;
        width: 100px;
        text-align: center;
        margin-left: -25px;
    }
    
    .step.active .step-label {
        color: var(--orange-primary);
        font-weight: 600;
    }
    
    .step.completed .step-label {
        color: var(--orange-primary);
        font-weight: 600;
    }
    
    .form-container {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 30px;
        margin-bottom: 30px;
    }
    
    .section-title {
        color: var(--orange-primary);
        font-weight: 600;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 10px;
        font-size: 20px;
    }
    
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 8px;
    }
    
    .form-control, .form-select {
        padding: 12px 16px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 15px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--orange-primary);
        box-shadow: 0 0 0 0.25rem rgba(255, 122, 0, 0.25);
    }
    
    .dropzone-area {
        border: 2px dashed var(--orange-primary);
        border-radius: 12px;
        background-color: var(--orange-light);
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .dropzone-area:hover {
        background-color: #fff0e6;
    }
    
    .size-container {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .size-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .size-badge {
        background-color: var(--orange-primary);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
        margin-right: 10px;
    }
    
    .nav-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
    }
    
    .required-field::after {
        content: "*";
        color: red;
        margin-left: 4px;
    }
    
    .wajib-field {
        font-size: 12px;
        color: #6c757d;
    }
</style>
<body>
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class=" align-items-center">
                <h2 class="text-orange fw-bold mb-0">Edit Produk</h2>
                <p class="mb-5">Lengkapi informasi produk Anda di bawah ini</p>
            </div>
            
            <!-- Progress Steps -->
            <div class="progress-container">
                <div class="progress-steps">
                    <div class="step completed">
                        <span>1</span>
                        <div class="step-label">Info Toko</div>
                    </div>
                    <div class="progress-line"></div>
                    <div class="progress-line-active" style="width: 33%;"></div>
                    <div class="step active">
                        <span>2</span>
                        <div class="step-label">Produk</div>
                    </div>
                    <div class="step">
                        <span>3</span>
                        <div class="step-label">Harga</div>
                    </div>
                    <div class="step">
                        <span>4</span>
                        <div class="step-label">Selesai</div>
                    </div>
                </div>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger rounded-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" id="productForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="seller_id" value="{{ $seller->id }}">
                
                <!-- Product Information Section -->
                <div class="form-container">
                    <div class="section-title">
                        <i class="bi bi-info-circle"></i> Informasi Produk
                    </div>
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label required-field">Kategori</label>
                        <select id="category_id" class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label required-field">Nama Barang</label>
                        <input id="nama_barang" type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                            name="nama_barang" value="{{ old('nama_barang', $product->nama_barang) }}" 
                            placeholder="Masukkan nama produk" required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label required-field">Deskripsi</label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" 
                            name="description" rows="4" placeholder="Jelaskan detail produk" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="lokasi" class="form-label required-field">Lokasi Toko</label>
                        <input id="lokasi" type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                            name="lokasi" value="{{ old('lokasi', $product->lokasi) }}" 
                            placeholder="Kota atau provinsi" required>
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="alamat_lengkap" class="form-label required-field">Alamat Lengkap</label>
                        <textarea id="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror" 
                            name="alamat_lengkap" rows="3" placeholder="Alamat lengkap toko" required>{{ old('alamat_lengkap', $product->alamat_lengkap) }}</textarea>
                        @error('alamat_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Product Image Section -->
                <div class="form-container">
                    <div class="section-title">
                        <i class="bi bi-image"></i> Gambar Produk
                    </div>
                    
                    <div class="dropzone-wrapper">
                        @if($product->gambar)
                            <div class="preview-zone visible mb-3">
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="Gambar Produk" class="img-fluid rounded" style="max-height: 300px;">
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-change-image mb-3">
                                <i class="bi bi-arrow-repeat"></i> Ganti Gambar
                            </button>
                        @endif
                        
                        <div class="dropzone-area @if($product->gambar) d-none @endif">
                            <input type="file" class="form-control d-none" id="gambar" name="gambar" accept="image/*">
                            <div class="text-center">
                                <i class="bi bi-cloud-arrow-up text-orange" style="font-size: 48px;"></i>
                                <h5 class="mt-3">Klik untuk upload gambar</h5>
                                <p class="text-muted small">JPG, PNG maks. 5MB</p>
                            </div>
                        </div>
                        
                        @error('gambar')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Sizes and Prices Section -->
                <div class="form-container">
                    <div class="section-title">
                        <i class="bi bi-tag"></i> Ukuran dan Harga
                    </div>
                    
                    <p class="wajib-field mb-4"><i class="bi bi-info-circle"></i> Pilih minimal satu ukuran yang tersedia</p>
                    
                    @php 
                        $availableSizes = ['S', 'M', 'L', 'XL'];
                    @endphp
                    
                    @foreach($availableSizes as $sizeName)
                        @php
                            $size = $product->sizes->where('size', $sizeName)->first();
                        @endphp
                        
                        <div class="size-container">
                            <div class="size-header">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="size_active_{{ $sizeName }}" 
                                        name="size_active[{{ $sizeName }}]" {{ $size ? 'checked' : '' }}>
                                    <label class="form-check-label" for="size_active_{{ $sizeName }}">
                                        <span class="size-badge">Ukuran {{ $sizeName }}</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="size-details" id="size_details_{{ $sizeName }}" style="{{ $size ? '' : 'display: none;' }}">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="sizes_{{ $sizeName }}_harga" class="form-label required-field">Harga</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input id="sizes_{{ $sizeName }}_harga" type="number" class="form-control" 
                                                name="sizes[{{ $sizeName }}][harga]" value="{{ $size ? $size->harga : old('sizes.'.$sizeName.'.harga') }}" 
                                                placeholder="0" min="0">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="sizes_{{ $sizeName }}_stock" class="form-label required-field">Stok</label>
                                        <input id="sizes_{{ $sizeName }}_stock" type="number" class="form-control" 
                                            name="sizes[{{ $sizeName }}][stock]" value="{{ $size ? $size->stock : old('sizes.'.$sizeName.'.stock') }}" 
                                            placeholder="0" min="0">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="sizes_{{ $sizeName }}_gambar" class="form-label">Gambar Ukuran (Opsional)</label>
                                    
                                    <div class="size-dropzone-wrapper">
                                        @if($size && $size->gambar_size)
                                            <div class="size-preview-zone visible mb-2">
                                                <img src="{{ asset('storage/' . $size->gambar_size) }}" alt="Gambar Ukuran {{ $sizeName }}" class="img-fluid rounded" style="max-height: 100px;">
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-change-size-image mb-2" data-size="{{ $sizeName }}">
                                                <i class="bi bi-arrow-repeat"></i> Ganti
                                            </button>
                                        @endif
                                        
                                        <div class="size-dropzone-area @if($size && $size->gambar_size) d-none @endif p-3 border rounded text-center" style="background-color: #f8f9fa;">
                                            <input id="sizes_{{ $sizeName }}_gambar" type="file" class="form-control d-none" name="sizes[{{ $sizeName }}][gambar]" accept="image/*">
                                            <div class="text-center">
                                                <i class="bi bi-cloud-arrow-up text-orange"></i>
                                                <p class="mb-0 small">Klik untuk upload gambar ukuran</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Navigation Buttons -->
                <div class="nav-buttons">
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-orange">
                        Simpan Produk <i class="bi bi-check-circle ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Size checkbox toggle functionality
        const sizeCheckboxes = document.querySelectorAll('input[name^="size_active"]');
        
        sizeCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const sizeName = this.id.replace('size_active_', '');
                const sizeDetails = document.getElementById('size_details_' + sizeName);
                
                if (this.checked) {
                    $(sizeDetails).slideDown(300);
                } else {
                    $(sizeDetails).slideUp(300);
                }
            });
        });
        
        // Main product image upload
        const mainDropzoneArea = document.querySelector('.dropzone-area');
        const mainFileInput = document.getElementById('gambar');
        const mainPreviewZone = document.querySelector('.preview-zone');
        const mainChangeBtn = document.querySelector('.btn-change-image');
        
        if (mainDropzoneArea && mainFileInput) {
            mainDropzoneArea.addEventListener('click', function() {
                mainFileInput.click();
            });
            
            mainFileInput.addEventListener('change', function() {
                if (this.files.length) {
                    const file = this.files[0];
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        // Create preview if it doesn't exist yet
                        if (!mainPreviewZone) {
                            const previewDiv = document.createElement('div');
                            previewDiv.classList.add('preview-zone', 'visible', 'mb-3');
                            mainDropzoneArea.parentNode.insertBefore(previewDiv, mainDropzoneArea);
                            
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('img-fluid', 'rounded');
                            img.style.maxHeight = '300px';
                            previewDiv.appendChild(img);
                            
                            // Create change button
                            const changeBtn = document.createElement('button');
                            changeBtn.type = 'button';
                            changeBtn.classList.add('btn', 'btn-outline-secondary', 'btn-change-image', 'mb-3', 'mt-2');
                            changeBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Ganti Gambar';
                            mainDropzoneArea.parentNode.insertBefore(changeBtn, mainDropzoneArea);
                            
                            changeBtn.addEventListener('click', function() {
                                mainDropzoneArea.classList.remove('d-none');
                                previewDiv.classList.add('d-none');
                            });
                            
                            mainDropzoneArea.classList.add('d-none');
                        } else {
                            // Update existing preview
                            const img = mainPreviewZone.querySelector('img') || document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('img-fluid', 'rounded');
                            img.style.maxHeight = '300px';
                            
                            if (!mainPreviewZone.querySelector('img')) {
                                mainPreviewZone.appendChild(img);
                            }
                            
                            mainPreviewZone.classList.remove('d-none');
                            mainDropzoneArea.classList.add('d-none');
                            
                            if (mainChangeBtn) {
                                mainChangeBtn.classList.remove('d-none');
                            }
                        }
                    };
                    
                    reader.readAsDataURL(file);
                }
            });
            
            if (mainChangeBtn) {
                mainChangeBtn.addEventListener('click', function() {
                    mainDropzoneArea.classList.remove('d-none');
                    if (mainPreviewZone) {
                        mainPreviewZone.classList.add('d-none');
                    }
                    this.classList.add('d-none');
                });
            }
        }
        
        // Size image uploads
        const sizeDropzoneAreas = document.querySelectorAll('.size-dropzone-area');
        
        sizeDropzoneAreas.forEach(function(dropzoneArea) {
            const sizeFileInput = dropzoneArea.querySelector('input[type="file"]');
            
            if (sizeFileInput) {
                dropzoneArea.addEventListener('click', function() {
                    sizeFileInput.click();
                });
                
                sizeFileInput.addEventListener('change', function() {
                    if (this.files.length) {
                        const file = this.files[0];
                        const reader = new FileReader();
                        const sizeName = this.id.replace('sizes_', '').replace('_gambar', '');
                        
                        reader.onload = function(e) {
                            const previewZone = document.querySelector(`.size-preview-zone[data-size="${sizeName}"]`) || 
                                               document.createElement('div');
                            
                            if (!previewZone.classList.contains('size-preview-zone')) {
                                previewZone.classList.add('size-preview-zone', 'visible', 'mb-2');
                                previewZone.setAttribute('data-size', sizeName);
                                dropzoneArea.parentNode.insertBefore(previewZone, dropzoneArea);
                                
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.classList.add('img-fluid', 'rounded');
                                img.style.maxHeight = '100px';
                                img.alt = `Gambar Ukuran ${sizeName}`;
                                previewZone.appendChild(img);
                                
                                // Create change button
                                const changeBtn = document.createElement('button');
                                changeBtn.type = 'button';
                                changeBtn.classList.add('btn', 'btn-sm', 'btn-outline-secondary', 'btn-change-size-image', 'mb-2', 'mt-2');
                                changeBtn.setAttribute('data-size', sizeName);
                                changeBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Ganti';
                                dropzoneArea.parentNode.insertBefore(changeBtn, dropzoneArea);
                                
                                changeBtn.addEventListener('click', function() {
                                    dropzoneArea.classList.remove('d-none');
                                    previewZone.classList.add('d-none');
                                    this.classList.add('d-none');
                                });
                                
                                dropzoneArea.classList.add('d-none');
                            } else {
                                // Update existing preview
                                const img = previewZone.querySelector('img') || document.createElement('img');
                                img.src = e.target.result;
                                
                                if (!previewZone.querySelector('img')) {
                                    previewZone.appendChild(img);
                                }
                                
                                previewZone.classList.remove('d-none');
                                dropzoneArea.classList.add('d-none');
                                
                                const changeBtn = document.querySelector(`.btn-change-size-image[data-size="${sizeName}"]`);
                                if (changeBtn) {
                                    changeBtn.classList.remove('d-none');
                                }
                            }
                        };
                        
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
        
        // Existing change buttons for size images
        const sizeChangeBtns = document.querySelectorAll('.btn-change-size-image');
        
        sizeChangeBtns.forEach(function(btn) {
            const sizeName = btn.getAttribute('data-size');
            const dropzoneArea = document.querySelector(`.size-dropzone-area[data-size="${sizeName}"]`) || 
                                document.querySelector('.size-dropzone-area');
            const previewZone = document.querySelector(`.size-preview-zone[data-size="${sizeName}"]`) || 
                               document.querySelector('.size-preview-zone');
            
            btn.addEventListener('click', function() {
                if (dropzoneArea) {
                    dropzoneArea.classList.remove('d-none');
                }
                if (previewZone) {
                    previewZone.classList.add('d-none');
                }
                btn.classList.add('d-none');
            });
        });
        
        // Form validation
        const form = document.getElementById('productForm');
        
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const activeSize = document.querySelectorAll('input[name^="size_active"]:checked');
            
            if (activeSize.length === 0) {
                alert('Pilih minimal satu ukuran untuk produk ini!');
                isValid = false;
            } else {
                activeSize.forEach(checkbox => {
                    const sizeName = checkbox.id.replace('size_active_', '');
                    const hargaInput = document.getElementById(`sizes_${sizeName}_harga`);
                    const stockInput = document.getElementById(`sizes_${sizeName}_stock`);
                    
                    if (!hargaInput.value || hargaInput.value <= 0) {
                        alert(`Masukkan harga yang valid untuk ukuran ${sizeName}!`);
                        hargaInput.focus();
                        isValid = false;
                    }
                    
                    if (!stockInput.value || stockInput.value < 0) {
                        alert(`Masukkan stock yang valid untuk ukuran ${sizeName}!`);
                        stockInput.focus();
                        isValid = false;
                    }
                });
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>
</body>
</html>
@endsection