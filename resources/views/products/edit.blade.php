
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/edit-product.css') }}">
</head>
<body>
    <div class="main-container">
        <!-- Header Section -->
        <div class="header-section">
            <h4>Tambah Produk Baru</h4>
            <p>Lengkapi informasi produk Anda di bawah ini</p>
        </div>

        <div class="form-content">
            <!-- Error Display -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
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
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <h5 class="section-title">Informasi Produk</h5>
                </div>

                <div class="form-group">
                    <label for="category_id" class="form-label">
                        Kategori <span class="required-tag">Wajib</span>
                    </label>
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

                <div class="form-group">
                    <label for="nama_barang" class="form-label">
                        Nama Barang <span class="required-tag">Wajib</span>
                    </label>
                    <input id="nama_barang" type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                        name="nama_barang" value="{{ old('nama_barang', $product->nama_barang) }}" 
                        placeholder="Masukkan nama produk" required>
                    @error('nama_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">
                        Deskripsi <span class="required-tag">Wajib</span>
                    </label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" 
                        name="description" rows="4" placeholder="Jelaskan detail produk Anda" required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="lokasi" class="form-label">
                        Lokasi Toko <span class="required-tag">Wajib</span>
                    </label>
                    <div class="location-wrapper">
                        <i class="bi bi-geo-alt location-icon"></i>
                        <input id="lokasi" type="text" class="form-control location-input @error('lokasi') is-invalid @enderror" 
                            name="lokasi" value="{{ old('lokasi', $product->lokasi) }}" 
                            placeholder="Kota atau provinsi" required>
                    </div>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="alamat_lengkap" class="form-label">
                        Alamat Lengkap <span class="required-tag">Wajib</span>
                    </label>
                    <textarea id="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror" 
                        name="alamat_lengkap" rows="3" placeholder="Alamat lengkap toko Anda" required>{{ old('alamat_lengkap', $product->alamat_lengkap) }}</textarea>
                    @error('alamat_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Product Image Section -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-image"></i>
                    </div>
                    <h5 class="section-title">Gambar Produk <span class="required-tag">Wajib</span></h5>
                </div>

                <div class="form-group">
                    @if($product->gambar)
                        <div class="image-preview" id="imagePreview">
                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="Gambar Produk">
                        </div>
                        <button type="button" class="change-image-btn" id="changeImageBtn">
                            <i class="bi bi-arrow-repeat"></i> Ganti Gambar
                        </button>
                    @endif
                    
                    <div class="upload-section" id="uploadSection" @if($product->gambar) style="display: none;" @endif>
                        <input type="file" id="gambar" name="gambar" accept="image/*">
                        <div class="upload-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <div class="upload-text">Klik untuk upload gambar</div>
                        <div class="upload-subtitle">JPG, PNG maks. 5MB</div>
                    </div>
                    
                    @error('gambar')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sizes and Prices Section -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-tag"></i>
                    </div>
                    <h5 class="section-title">Ukuran dan Harga</h5>
                </div>

                <div class="required-notice">
                    <i class="bi bi-info-circle"></i>
                    Pilih minimal satu ukuran yang tersedia
                </div>

                @php 
                    $availableSizes = ['S', 'M', 'L', 'XL'];
                @endphp

                @foreach($availableSizes as $sizeName)
                    @php
                        $size = $product->sizes->where('size', $sizeName)->first();
                    @endphp
                    
                    <div class="size-container">
                        <div class="size-header" onclick="toggleSize('{{ $sizeName }}')">
                            <label class="size-label">
                                <input class="size-checkbox" type="checkbox" id="size_active_{{ $sizeName }}" 
                                    name="size_active[{{ $sizeName }}]" {{ $size ? 'checked' : '' }}
                                    onclick="event.stopPropagation();">
                                Ukuran 
                                <span class="size-badge">{{ $sizeName }}</span>
                            </label>
                        </div>
                        
                        <div class="size-details {{ $size ? 'active' : '' }}" id="size_details_{{ $sizeName }}">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="sizes_{{ $sizeName }}_harga" class="form-label">
                                        Harga <span class="required-tag">Wajib</span>
                                    </label>
                                    <div class="price-input-group">
                                        <span class="currency-label">Rp</span>
                                        <input id="sizes_{{ $sizeName }}_harga" type="number" class="form-control price-input" 
                                            name="sizes[{{ $sizeName }}][harga]" value="{{ $size ? $size->harga : old('sizes.'.$sizeName.'.harga') }}" 
                                            placeholder="0" min="0">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="sizes_{{ $sizeName }}_stock" class="form-label">
                                        Stok <span class="required-tag">Wajib</span>
                                    </label>
                                    <input id="sizes_{{ $sizeName }}_stock" type="number" class="form-control" 
                                        name="sizes[{{ $sizeName }}][stock]" value="{{ $size ? $size->stock : old('sizes.'.$sizeName.'.stock') }}" 
                                        placeholder="0" min="0">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="sizes_{{ $sizeName }}_gambar" class="form-label">
                                    Gambar Ukuran (Opsional)
                                </label>
                                
                                @if($size && $size->gambar_size)
                                    <div class="size-image-preview" id="sizeImagePreview_{{ $sizeName }}">
                                        <img src="{{ asset('storage/' . $size->gambar_size) }}" alt="Gambar Ukuran {{ $sizeName }}">
                                    </div>
                                    <button type="button" class="change-image-btn" onclick="changeSizeImage('{{ $sizeName }}')">
                                        <i class="bi bi-arrow-repeat"></i> Ganti
                                    </button>
                                @endif
                                
                                <div class="size-image-upload" id="sizeImageUpload_{{ $sizeName }}" 
                                     @if($size && $size->gambar_size) style="display: none;" @endif
                                     onclick="document.getElementById('sizes_{{ $sizeName }}_gambar').click()">
                                    <input id="sizes_{{ $sizeName }}_gambar" type="file" name="sizes[{{ $sizeName }}][gambar]" accept="image/*">
                                    <div>
                                        <i class="bi bi-cloud-arrow-up" style="color: var(--orange-primary);"></i>
                                        <p class="mb-0 small">Klik untuk upload gambar ukuran</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </form>
        </div>

        <!-- Navigation Buttons -->
        <div class="nav-buttons">
            <a href="{{ route('seller.dashboard') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button type="submit" form="productForm" class="btn-save">
                Simpan Produk <i class="bi bi-check-circle"></i>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/edit-product.js') }}"></script>
</body>
</html>