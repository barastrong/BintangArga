@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<style>
    /* Main Layout & Typography */
:root {
  --primary-color: #ff7a30;
  --primary-dark: #e65a00;
  --secondary-color: #3b5998;
  --light-gray: #f5f7fa;
  --border-color: #e4e9f0;
  --success: #38b653;
  --danger: #e53e3e;
  --text-dark: #333333;
  --text-muted: #6c757d;
  --shadow-sm: 0 2px 5px rgba(0,0,0,0.05);
  --shadow-md: 0 4px 10px rgba(0,0,0,0.08);
  --border-radius: 8px;
}

body {
  font-family: 'Poppins', sans-serif;
  color: var(--text-dark);
  background-color: #f8f9fc;
  line-height: 1.6;
}

.main-container {
  max-width: 1200px;
  margin: 30px auto;
  padding: 0 15px;
}

/* Form Card Styling */
.form-card {
  background-color: #fff;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow-md);
  margin-bottom: 30px;
  overflow: hidden;
}

.form-card-header {
  background-color: #fff;
  padding: 25px 30px;
  border-bottom: 1px solid var(--border-color);
}

.page-title {
  font-size: 43px;
  font-weight: 600;
  color: var(--primary-color);
  margin-bottom: 8px;
}

.text-muted {
  color: var(--text-muted);
}

.card-body {
  padding: 30px;
}

/* Section Dividers */
.section-divider {
  display: flex;
  align-items: center;
  margin: 35px 0 20px;
  position: relative;
}

.section-divider::before {
  content: "";
  flex-grow: 1;
  height: 1px;
  background-color: var(--border-color);
  margin-right: 15px;
}

.section-divider::after {
  content: "";
  flex-grow: 1;
  height: 1px;
  background-color: var(--border-color);
  margin-left: 15px;
}

.section-icon {
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: var(--light-gray);
  border-radius: 50%;
  color: var(--primary-color);
}

/* Form Elements */
.form-label {
  font-weight: 500;
  margin-bottom: 8px;
  color: var(--text-dark);
  display: block;
}

.tag-label {
  font-size: 0.7rem;
  background-color: rgba(255, 122, 48, 0.1);
  color: var(--primary-color);
  padding: 2px 8px;
  border-radius: 20px;
  margin-left: 5px;
  font-weight: 500;
}

.form-control, .form-select {
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  padding: 12px;
  width: 100%;
  transition: all 0.3s ease;
  box-shadow: var(--shadow-sm);
}

.form-control:focus, .form-select:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(255, 122, 48, 0.15);
  outline: none;
}

.input-group {
  display: flex;
  box-shadow: var(--shadow-sm);
  border-radius: var(--border-radius);
  overflow: hidden;
}

.input-group-text {
  display: flex;
  align-items: center;
  padding: 0 15px;
  background-color: var(--light-gray);
  border: 1px solid var(--border-color);
  border-right: none;
  color: var(--text-muted);
}

.input-group .form-control {
  box-shadow: none;
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
}

/* Image Upload */
.dropzone-container {
  border: 2px dashed var(--border-color);
  border-radius: var(--border-radius);
  padding: 25px 20px;
  background-color: var(--light-gray);
  transition: all 0.3s ease;
  cursor: pointer;
}

.dropzone-container:hover {
  border-color: var(--primary-color);
  background-color: rgba(255, 122, 48, 0.05);
}

.upload-icon {
  color: var(--primary-color);
}

.preview-image-container {
  display: flex;
  justify-content: center;
}

.img-thumbnail {
  max-height: 150px;
  border-radius: var(--border-radius);
  border: 1px solid var(--border-color);
}

/* Size Cards */
.size-card {
  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  transition: all 0.3s ease;
}

.size-card.active {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(255, 122, 48, 0.1);
}

.card-header {
  background-color: var(--light-gray);
  border-bottom: 1px solid var(--border-color);
  padding: 15px 20px;
}

.size-details {
  display: none;
  padding: 20px;
}

.size-details.active {
  display: block;
  animation: fadeIn 0.3s;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Form Switch */
.form-check-input {
  cursor: pointer;
  width: 45px;
  height: 22px;
  appearance: none;
  position: relative;
  border-radius: 20px;
  background-color: #ddd;
  transition: all 0.3s;
}

.form-check-input:checked {
  background-color: var(--success);
}

.form-check-input::before {
  content: "";
  position: absolute;
  height: 18px;
  width: 18px;
  left: 2px;
  bottom: 1px;
  border-radius: 50%;
  background-color: white;
  transition: all 0.3s;
}

.form-check-input:checked::before {
  transform: translateX(23px);
}

.form-check-label {
  cursor: pointer;
}

/* Buttons */
.btn {
  border-radius: var(--border-radius);
  font-weight: 500;
  transition: all 0.3s;
  padding: 10px 20px;
  font-size: 0.9rem;
  border: none;
}

.btn-orange {
  background-color: var(--primary-color);
  color: white;
}

.btn-orange:hover {
  background-color: var(--primary-dark);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(255, 122, 48, 0.25);
}

.btn-light {
  background-color: var(--light-gray);
  color: var(--text-dark);
}

.btn-light:hover {
  background-color: #e9ecef;
}

/* Alert Styling */
.alert {
  padding: 15px;
  border-radius: var(--border-radius);
  margin-bottom: 20px;
}

.alert-danger {
  background-color: #fff5f5;
  border-left: 5px solid var(--danger);
}

/* Validation Feedback */
.invalid-feedback {
  display: none;
  color: var(--danger);
  font-size: 0.8rem;
  margin-top: 5px;
}

.is-invalid {
  border-color: var(--danger) !important;
}

.is-invalid:focus {
  box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.15) !important;
}

/* Badges */
.badge {
  padding: 5px 10px;
  font-weight: 500;
  font-size: 0.75rem;
  border-radius: 15px;
}

.bg-success {
  background-color: var(--success) !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .card-body {
    padding: 20px 15px;
  }
  
  .section-divider h5 {
    font-size: 1rem;
  }
  
  .btn {
    width: 100%;
    margin-bottom: 10px;
  }
}
</style>
<body>
<div class="main-container">
    <div class="form-card">
        <div class="form-card-header">
            <h2 class="page-title mb-1">Tambah Produk Baru</h2>
            <p class="text-muted mb-0">Lengkapi informasi produk Anda di bawah ini</p>
        </div>
        <div class="card-body p-md-5 p-4">
            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-lg shadow-sm mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-3 text-danger fa-lg"></i>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                <input type="hidden" name="seller_id" value="{{ $seller->id }}">
                
                <!-- Product Information Section -->
                <div class="section-divider">
                    <div class="section-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h5 class="fw-bold mb-0 ms-3 me-3">Informasi Produk</h5>
                </div>
                
                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id" class="form-label">Kategori <span class="tag-label">Wajib</span></label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nama_barang" class="form-label">Nama Barang <span class="tag-label">Wajib</span></label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control" placeholder="Masukkan nama produk" required>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Deskripsi <span class="tag-label">Wajib</span></label>
                            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Jelaskan detail produk Anda" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lokasi" class="form-label">Lokasi Toko <span class="tag-label">Wajib</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Kota atau provinsi" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat_lengkap" class="form-label">Alamat Lengkap <span class="tag-label">Wajib</span></label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control" rows="3" placeholder="Alamat lengkap toko Anda" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="gambar" class="form-label">Gambar Produk <span class="tag-label">Wajib</span></label>
                            <div class="dropzone-container text-center">
                                <input type="file" name="gambar" id="gambar" class="form-control d-none" accept="image/*" hidden required>
                                <label for="gambar" class="d-block cursor-pointer mb-2">
                                    <div class="upload-icon mb-3">
                                        <i class="fas fa-cloud-upload-alt fa-3x"></i>
                                    </div>
                                    <p class="mb-1 fw-medium">Klik untuk upload gambar</p>
                                    <small class="text-muted">JPG, PNG maks. 5MB</small>
                                </label>
                                <div class="mt-3 preview-image-container">
                                    <img id="preview" class="img-thumbnail shadow-sm rounded" style="display: none; max-width: 200px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Size and Price Section -->
                <div class="section-divider mt-5">
                    <div class="section-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h5 class="fw-bold mb-0 ms-3 me-3">Ukuran dan Harga</h5>
                </div>
                
                <div class="row g-4 mt-2">
                    @foreach(['S', 'M', 'L', 'XL'] as $size)
                    <div class="col-md-6 mb-3">
                        <div class="size-card h-100" id="card_{{ $size }}">
                            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" name="size_active[{{ $size }}]" 
                                               id="toggle_{{ $size }}" onchange="toggleSize('{{ $size }}')">
                                        <label class="form-check-label fw-medium ms-2" for="toggle_{{ $size }}">
                                            Ukuran {{ $size }}
                                        </label>
                                    </div>
                                </div>
                                <span class="badge bg-light text-dark me-2" id="status_{{ $size }}">Tidak Aktif</span>
                            </div>
                            <div class="card-body size-details p-4" id="size_details_{{ $size }}">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="harga_{{ $size }}" class="form-label">Harga</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" name="sizes[{{ $size }}][harga]" 
                                                       id="harga_{{ $size }}" class="form-control" 
                                                       data-size="{{ $size }}" min="0" placeholder="0">
                                            </div>
                                            <div class="invalid-feedback" id="harga_feedback_{{ $size }}">
                                                Harga wajib diisi
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="stock_{{ $size }}" class="form-label">Stok</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-boxes"></i>
                                                </span>
                                                <input type="number" name="sizes[{{ $size }}][stock]" 
                                                       id="stock_{{ $size }}" class="form-control" 
                                                       data-size="{{ $size }}" min="0" placeholder="0">
                                            </div>
                                            <div class="invalid-feedback" id="stock_feedback_{{ $size }}">
                                                Stok wajib diisi
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="gambar_{{ $size }}" class="form-label">Gambar Ukuran {{ $size }}</label>
                                    <div class="dropzone-container p-3 text-center">
                                        <input type="file" name="sizes[{{ $size }}][gambar]" 
                                              id="gambar_{{ $size }}" class="form-control d-none size-input" 
                                              data-size="{{ $size }}" accept="image/*" hidden >
                                        <label for="gambar_{{ $size }}" class="d-block cursor-pointer mb-0">
                                            <i class="fas fa-image upload-icon me-1"></i>
                                            <small>Klik untuk upload gambar</small>
                                        </label>
                                        <div class="mt-2 preview-image-container">
                                            <img id="preview_{{ $size }}" class="img-thumbnail shadow-sm rounded" 
                                                 style="display: none; max-width: 150px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="text-center mt-5 pt-3 border-top">
                    <a href="{{ route('products.index') }}">
                    <button type="button" class="btn btn-light fw-medium me-2 px-4 py-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                    </a>
                    <button type="submit" class="btn btn-orange px-4 py-2 shadow-sm">
                        <i class="fas fa-save me-2"></i>Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview gambar produk
    document.getElementById('gambar').addEventListener('change', function(e) {
        previewImage(this, 'preview');
        
        const uploadLabel = this.previousElementSibling;
        if (this.files && this.files[0]) {
            uploadLabel.innerHTML = '<i class="fas fa-check-circle text-success fa-2x mb-3"></i><p class="mb-0">Image uploaded</p>';
        }
    });

    // Form validation
    document.getElementById('productForm').addEventListener('submit', function(e) {
        const activeSizes = document.querySelectorAll('input[name^="size_active"]:checked');
        let isValid = true;
        
        if (activeSizes.length === 0) {
            e.preventDefault();
            showAlert('Mohon pilih minimal satu ukuran');
            return;
        }
        
        activeSizes.forEach(sizeCheckbox => {
            const size = sizeCheckbox.id.replace('toggle_', '');
            const hargaInput = document.getElementById(`harga_${size}`);
            const stockInput = document.getElementById(`stock_${size}`);
            
            if (!hargaInput.value) {
                isValid = false;
                hargaInput.classList.add('is-invalid');
                document.getElementById(`harga_feedback_${size}`).style.display = 'block';
            } else {
                hargaInput.classList.remove('is-invalid');
                document.getElementById(`harga_feedback_${size}`).style.display = 'none';
            }
            
            if (!stockInput.value) {
                isValid = false;
                stockInput.classList.add('is-invalid');
                document.getElementById(`stock_feedback_${size}`).style.display = 'block';
            } else {
                stockInput.classList.remove('is-invalid');
                document.getElementById(`stock_feedback_${size}`).style.display = 'none';
            }
        });

        if (!isValid) {
            e.preventDefault();
            showAlert('Mohon lengkapi semua data untuk ukuran yang dipilih');
        }
    });
});

function showAlert(message) {
    // Create custom alert
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-4 shadow';
    alertDiv.style.zIndex = '9999';
    alertDiv.style.borderLeft = '5px solid #E53E3E';
    alertDiv.style.borderRadius = '8px';
    alertDiv.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle me-3 text-danger fa-lg"></i>
            <div>${message}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.body.appendChild(alertDiv);
    
    // Auto dismiss after 3 seconds
    setTimeout(() => {
        alertDiv.classList.remove('show');
        setTimeout(() => alertDiv.remove(), 300);
    }, 3000);
}

function toggleSize(size) {
    const details = document.getElementById(`size_details_${size}`);
    const toggle = document.getElementById(`toggle_${size}`);
    const card = document.getElementById(`card_${size}`);
    const statusBadge = document.getElementById(`status_${size}`);
    
    if (toggle.checked) {
        details.classList.add('active');
        card.classList.add('active');
        statusBadge.textContent = 'Aktif';
        statusBadge.className = 'badge bg-success text-white me-2';
        
        // Reset any validation errors
        const inputs = card.querySelectorAll('input');
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
        // Hide feedback messages
        const feedbacks = card.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(feedback => {
            feedback.style.display = 'none';
        });
    } else {
        details.classList.remove('active');
        card.classList.remove('active');
        statusBadge.textContent = 'Tidak Aktif';
        statusBadge.className = 'badge bg-light text-dark me-2';
        
        // Clear inputs
        const hargaInput = document.getElementById(`harga_${size}`);
        const stockInput = document.getElementById(`stock_${size}`);
        const imageInput = document.getElementById(`gambar_${size}`);
        
        if (hargaInput) hargaInput.value = '';
        if (stockInput) stockInput.value = '';
        if (imageInput) imageInput.value = '';
        
        const preview = document.getElementById(`preview_${size}`);
        if (preview) {
            preview.style.display = 'none';
            preview.src = '';
        }
    }
}

function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.style.display = 'block';
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Add preview for size images
['S', 'M', 'L', 'XL'].forEach(size => {
    const input = document.getElementById(`gambar_${size}`);
    if (input) {
        input.addEventListener('change', function(e) {
            previewImage(this, `preview_${size}`);
            
            const uploadLabel = this.previousElementSibling;
            if (this.files && this.files[0]) {
                uploadLabel.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i> Image uploaded';
            }
        });
    }
    
    // Add form input validation handlers
    const hargaInput = document.getElementById(`harga_${size}`);
    const stockInput = document.getElementById(`stock_${size}`);
    
    if (hargaInput) {
        hargaInput.addEventListener('input', function() {
            if (this.value) {
                this.classList.remove('is-invalid');
                document.getElementById(`harga_feedback_${size}`).style.display = 'none';
            }
        });
    }
    
    if (stockInput) {
        stockInput.addEventListener('input', function() {
            if (this.value) {
                this.classList.remove('is-invalid');
                document.getElementById(`stock_feedback_${size}`).style.display = 'none';
            }
        });
    }
});
</script>
</html>
@endsection