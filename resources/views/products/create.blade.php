@extends('layouts.app')

@section('content')
{{-- resources/views/products/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru</title>
    <style>
                .size-container {
                    border: 1px solid #ddd;
                    padding: 15px;
                    margin-bottom: 15px;
                    border-radius: 4px;
                }
                
                .size-toggle {
                    margin-bottom: 10px;
                }
                
                .size-details {
                    display: none;
                    padding: 10px;
                    background-color: #f8f9fa;
                    border-radius: 4px;
                }
                
                .size-details.active {
                    display: block;
                }
            
                .preview-image {
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    padding: 5px;
                }
            
                .form-group {
                    margin-bottom: 1rem;
                }
            </style>
</head>
<body>
<div class="container">
    <div class="form-container">
        <h2>Tambah Produk Baru</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            
            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi Toko</label>
                <input type="text" name="lokasi" id="lokasi" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="alamat_lengkap">Alamat Lengkap</label>
                <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control" rows="2" required></textarea>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Produk</label>
                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" required>
                <img id="preview" class="preview-image" style="display: none; max-width: 200px; margin-top: 10px;">
            </div>

            <h3>Ukuran dan Harga</h3>
            <p>Centang ukuran yang tersedia:</p>
            
            @foreach(['S', 'M', 'L', 'XL'] as $size)
            <div class="size-container">
                <div class="size-toggle">
                    <input type="checkbox" name="size_active[{{ $size }}]" id="toggle_{{ $size }}" 
                           onchange="toggleSize('{{ $size }}')">
                    <label for="toggle_{{ $size }}">Ukuran {{ $size }} Tersedia</label>
                </div>

                <div id="size_details_{{ $size }}" class="size-details">
                    <div class="form-group">
                        <label for="harga_{{ $size }}">Harga</label>
                        <input type="number" name="sizes[{{ $size }}][harga]" id="harga_{{ $size }}" 
                               class="form-control size-input" data-size="{{ $size }}" min="0">
                    </div>

                    <div class="form-group">
                        <label for="stock_{{ $size }}">Stok</label>
                        <input type="number" name="sizes[{{ $size }}][stock]" id="stock_{{ $size }}" 
                               class="form-control size-input" data-size="{{ $size }}" min="0">
                    </div>

                    <div class="form-group">
                        <label for="gambar_{{ $size }}">Gambar Ukuran {{ $size }}</label>
                        <input type="file" name="sizes[{{ $size }}][gambar]" id="gambar_{{ $size }}" 
                               class="form-control size-input" data-size="{{ $size }}" accept="image/*">
                        <img id="preview_{{ $size }}" class="preview-image" 
                             style="display: none; max-width: 200px; margin-top: 10px;">
                    </div>
                </div>
            </div>
            @endforeach

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview gambar produk
    document.getElementById('gambar').addEventListener('change', function(e) {
        previewImage(this, 'preview');
    });

    // Form submission handling
    document.getElementById('productForm').addEventListener('submit', function(e) {
        const activeSizes = document.querySelectorAll('input[name^="size_active"]:checked');
        
        activeSizes.forEach(sizeCheckbox => {
            const size = sizeCheckbox.id.replace('toggle_', '');
            const inputs = document.querySelectorAll(`.size-input[data-size="${size}"]`);
            
            inputs.forEach(input => {
                if (!input.value) {
                    e.preventDefault();
                    alert(`Mohon lengkapi semua data untuk ukuran ${size}`);
                    return;
                }
            });
        });
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