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
:root {
    --orange-primary: #FF6B35;
    --orange-light: #FFE0D3;
    --orange-hover: #FF5722;
    --orange-ultra-light: #FFF5F0;
    --dark-text: #2D3748;
    --gray-light: #F8FAFC;
    --border-radius: 12px;
    --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
}

body {
    background-color: #FAFAFA;
    font-family: 'Poppins', sans-serif;
}

.main-container {
    max-width: 1080px;
    margin: 40px auto;
    padding: 0 20px;
}

.form-card {
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    border: none;
    overflow: hidden;
    transition: all 0.4s ease;
    background-color: #ffffff;
}

.form-card-header {
    padding: 35px 40px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
    background: linear-gradient(to right, rgba(255, 107, 53, 0.03), rgba(255, 107, 53, 0.01));
}

.form-card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 6px;
    height: 100%;
    background: linear-gradient(to bottom, var(--orange-primary), var(--orange-hover));
}

.form-control, .form-select {
    border-radius: 10px;
    padding: 14px 18px;
    font-size: 14px;
    border: 1px solid #E2E8F0;
    background-color: var(--gray-light);
    transition: all 0.3s ease;
    font-weight: 400;
}

.form-control:focus, .form-select:focus {
    box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.15);
    border-color: var(--orange-primary);
    background-color: #fff;
}

.section-divider {
    display: flex;
    align-items: center;
    margin: 35px 0;
}

.section-divider::before,
.section-divider::after {
    content: "";
    flex: 1;
    height: 1px;
    background: linear-gradient(to right, rgba(226, 232, 240, 0.5), rgba(226, 232, 240, 1), rgba(226, 232, 240, 0.5));
}

.section-divider .section-icon {
    padding: 0 20px;
}

.section-icon {
    background: linear-gradient(135deg, var(--orange-ultra-light), white);
    color: var(--orange-primary);
    width: 54px;
    height: 54px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 1.2rem;
    box-shadow: 0 4px 12px rgba(255, 107, 53, 0.12);
    border: 2px solid rgba(255, 107, 53, 0.1);
}

.dropzone-container {
    border: 2px dashed #E2E8F0;
    transition: all 0.3s ease;
    border-radius: var(--border-radius);
    background-color: var(--gray-light);
}

.dropzone-container:hover {
    border-color: var(--orange-primary);
    background-color: var(--orange-ultra-light);
}

.size-details {
    display: none;
    transition: all 0.3s ease;
}

.size-details.active {
    display: block;
    animation: fadeIn 0.4s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.size-card {
    transition: all 0.3s ease;
    border-radius: var(--border-radius);
    border: 1px solid #E2E8F0;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
}

.size-card.active {
    border-color: var(--orange-primary);
    box-shadow: 0 5px 20px rgba(255, 107, 53, 0.15);
    transform: translateY(-3px);
}

.size-card .card-header {
    background-color: #fff;
    transition: all 0.3s ease;
    border-bottom: 1px solid #E2E8F0;
    padding: 16px 20px;
}

.size-card.active .card-header {
    background: linear-gradient(to right, var(--orange-ultra-light), white);
    border-bottom: 1px solid var(--orange-light);
}

/* Custom form switch for orange color */
.form-check-input:checked {
    background-color: var(--orange-primary);
    border-color: var(--orange-primary);
}

.form-switch .form-check-input {
    height: 1.5em;
    width: 3em;
}

.btn-orange {
    background: linear-gradient(45deg, var(--orange-primary), var(--orange-hover));
    border: none;
    color: white;
    transition: all 0.3s ease;
    font-weight: 600;
    padding: 14px 32px;
    border-radius: 10px;
}

.btn-orange:hover {
    background: linear-gradient(45deg, var(--orange-hover), var(--orange-primary));
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(255, 107, 53, 0.25);
}

.btn-light {
    background-color: #EDF2F7;
    border: none;
    color: #4A5568;
    font-weight: 500;
    padding: 14px 32px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-light:hover {
    background-color: #E2E8F0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.form-label {
    font-weight: 500;
    margin-bottom: 10px;
    color: #4A5568;
    font-size: 14px;
    letter-spacing: 0.3px;
}

.page-title {
    background: linear-gradient(45deg, var(--orange-primary), #FF9671);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 700;
    letter-spacing: -0.5px;
    font-size: 28px;
}

.upload-icon {
    color: var(--orange-primary);
}

.alert {
    border-radius: var(--border-radius);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.input-group-text {
    background: linear-gradient(to right, var(--orange-ultra-light), white);
    color: var(--orange-primary);
    border: 1px solid #E2E8F0;
    border-right: 0;
    font-weight: 500;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    padding: 0 16px;
}

.input-group .form-control {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.progress-container {
    margin-top: 30px;
    margin-bottom: 15px;
}

.progress-steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin-bottom: 20px;
}

.progress-steps::before {
    content: '';
    position: absolute;
    top: 15px;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(to right, 
        var(--orange-primary) 25%, 
        #E2E8F0 25%, #E2E8F0 100%);
    z-index: 1;
    border-radius: 10px;
}

.step {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.step-circle {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background-color: #E2E8F0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 8px;
    color: #4A5568;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 14px;
}

.step.active .step-circle {
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-hover));
    color: white;
    box-shadow: 0 0 0 5px var(--orange-ultra-light);
}

.step.completed .step-circle {
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-hover));
    color: white;
    box-shadow: 0 0 0 5px var(--orange-ultra-light);
}

.step-label {
    font-size: 13px;
    font-weight: 500;
    color: #718096;
}

.step.active .step-label {
    color: var(--orange-primary);
    font-weight: 600;
}

.cursor-pointer {
    cursor: pointer;
}

.is-invalid {
    border-color: #FC8181 !important;
    background-image: none !important;
}

.invalid-feedback {
    display: none;
    color: #E53E3E;
    font-size: 12px;
    margin-top: 4px;
}

.tag-label {
    display: inline-block;
    background: linear-gradient(to right, var(--orange-ultra-light), white);
    color: var(--orange-primary);
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 600;
    margin-left: 10px;
    border: 1px solid rgba(255, 107, 53, 0.2);
}

.preview-image-container {
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.preview-image-container img {
    transition: all 0.3s ease;
}

.preview-image-container:hover img {
    transform: scale(1.05);
}

.card-body {
    background: linear-gradient(to bottom right, white, rgba(255, 255, 255, 0.8));
}

.img-thumbnail {
    border-radius: 10px;
    border: 2px solid rgba(255, 107, 53, 0.1);
}
</style>
<body>
<div class="main-container">
    <div class="form-card">
        <div class="form-card-header">
            <h2 class="page-title mb-1">Tambah Produk Baru</h2>
            <p class="text-muted mb-0">Lengkapi informasi produk Anda di bawah ini</p>
            
            <!-- Progress Steps -->
            <div class="progress-container">
                <div class="progress-steps">
                    <div class="step completed">
                        <div class="step-circle"><i class="fas fa-check"></i></div>
                        <span class="step-label">Info Toko</span>
                    </div>
                    <div class="step active">
                        <div class="step-circle">2</div>
                        <span class="step-label">Produk</span>
                    </div>
                    <div class="step">
                        <div class="step-circle">3</div>
                        <span class="step-label">Harga</span>
                    </div>
                    <div class="step">
                        <div class="step-circle">4</div>
                        <span class="step-label">Selesai</span>
                    </div>
                </div>
            </div>
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
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="tag-label">Wajib</span></label>
                            <select name="category_id" id="category_id" class="form-select shadow-none" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang <span class="tag-label">Wajib</span></label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control shadow-none" placeholder="Masukkan nama produk" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Deskripsi <span class="tag-label">Wajib</span></label>
                            <textarea name="description" id="description" class="form-control shadow-none" rows="4" placeholder="Jelaskan detail produk Anda" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="lokasi" class="form-label">Lokasi Toko <span class="tag-label">Wajib</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <input type="text" name="lokasi" id="lokasi" class="form-control shadow-none" placeholder="Kota atau provinsi" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat_lengkap" class="form-label">Alamat Lengkap <span class="tag-label">Wajib</span></label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control shadow-none" rows="2" placeholder="Alamat lengkap toko Anda" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="gambar" class="form-label">Gambar Produk <span class="tag-label">Wajib</span></label>
                            <div class="dropzone-container p-4 text-center">
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
                                                       id="harga_{{ $size }}" class="form-control shadow-none" 
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
                                                       id="stock_{{ $size }}" class="form-control shadow-none" 
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