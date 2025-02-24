@extends('layouts.app')

@section('content')
{{-- resources/views/products/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru</title>
</head>
<style>
.size-details {
    display: none;
}

.size-details.active {
    display: block;
}

.card-header {
    background-color: #f8f9fa;
}

.form-label {
    font-weight: 500;
}
</style>
<body>
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Tambah Produk Baru</h2>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                <input type="hidden" name="user_id" value="{{$products->user_id}}">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="lokasi" class="form-label">Lokasi Toko</label>
                            <input type="text" name="lokasi" id="lokasi" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="gambar" class="form-label">Gambar Produk</label>
                            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" required>
                            <div class="mt-2">
                                <img id="preview" class="img-thumbnail" style="display: none; max-width: 200px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h3 class="mb-0">Ukuran dan Harga</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach(['S', 'M', 'L', 'XL'] as $size)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="size_active[{{ $size }}]" 
                                                   id="toggle_{{ $size }}" onchange="toggleSize('{{ $size }}')">
                                            <label class="form-check-label" for="toggle_{{ $size }}">
                                                Ukuran {{ $size }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body size-details" id="size_details_{{ $size }}">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group mb-3">
                                                    <label for="harga_{{ $size }}" class="form-label">Harga</label>
                                                    <input type="number" name="sizes[{{ $size }}][harga]" 
                                                           id="harga_{{ $size }}" class="form-control size-input" 
                                                           data-size="{{ $size }}" min="0">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group mb-3">
                                                    <label for="stock_{{ $size }}" class="form-label">Stok</label>
                                                    <input type="number" name="sizes[{{ $size }}][stock]" 
                                                           id="stock_{{ $size }}" class="form-control size-input" 
                                                           data-size="{{ $size }}" min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="gambar_{{ $size }}" class="form-label">Gambar Ukuran {{ $size }}</label>
                                            <input type="file" name="sizes[{{ $size }}][gambar]" 
                                                   id="gambar_{{ $size }}" class="form-control size-input" 
                                                   data-size="{{ $size }}" accept="image/*">
                                            <div class="mt-2">
                                                <img id="preview_{{ $size }}" class="img-thumbnail" 
                                                     style="display: none; max-width: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview gambar produk
    document.getElementById('gambar').addEventListener('change', function(e) {
        previewImage(this, 'preview');
    });

    // Form validation
    document.getElementById('productForm').addEventListener('submit', function(e) {
        const activeSizes = document.querySelectorAll('input[name^="size_active"]:checked');
        let isValid = true;
        
        if (activeSizes.length === 0) {
            e.preventDefault();
            alert('Mohon pilih minimal satu ukuran');
            return;
        }
        
        activeSizes.forEach(sizeCheckbox => {
            const size = sizeCheckbox.id.replace('toggle_', '');
            const inputs = document.querySelectorAll(`.size-input[data-size="${size}"]`);
            
            inputs.forEach(input => {
                if (input.type !== 'file' && !input.value) {
                    isValid = false;
                    input.classList.add('is-invalid');
                }
            });
        });

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua data untuk ukuran yang dipilih');
        }
    });
});

function toggleSize(size) {
    const details = document.getElementById(`size_details_${size}`);
    const inputs = details.querySelectorAll('.size-input');
    const toggle = document.getElementById(`toggle_${size}`);
    
    if (toggle.checked) {
        details.classList.add('active');
        inputs.forEach(input => {
            if (input.type !== 'file') {
                input.value = input.value || '0';
            }
        });
    } else {
        details.classList.remove('active');
        inputs.forEach(input => {
            input.value = '';
            input.classList.remove('is-invalid');
            if (input.type === 'file') {
                const preview = document.getElementById(`preview_${size}`);
                if (preview) {
                    preview.style.display = 'none';
                    preview.src = '';
                }
            }
        });
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
        });
    }
});
</script>
</body>
</html>
@endsection