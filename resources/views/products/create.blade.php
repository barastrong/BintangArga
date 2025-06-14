@extends('layouts.app')

@section('content')
<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <div class="lg:col-span-1">
                @include('sellers.partials.sidebar')
            </div>

            <div class="lg:col-span-3">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Tambah Produk Baru</h1>
                    <p class="text-gray-500 mt-1">Lengkapi semua informasi di bawah ini untuk produk barumu.</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                        <p class="font-bold">Terjadi Kesalahan</p>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" id="productForm" class="space-y-8">
                    @csrf
                    <input type="hidden" name="seller_id" value="{{ $seller->id }}">

                    <!-- Card Informasi Produk & Lokasi -->
                    <div class="bg-white p-8 rounded-xl shadow-md">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-4">Informasi & Lokasi Produk</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Kolom Kiri --}}
                            <div class="space-y-4">
                                <div>
                                    <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                                    <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                </div>
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <select id="category_id" name="category_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea id="description" name="description" rows="5" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            {{-- Kolom Kanan --}}
                            <div class="space-y-4">
                                <div>
                                    <label for="province_id" class="block text-sm font-medium text-gray-700">Provinsi</label>
                                    <select id="province_id" name="province_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                        <option value="">Pilih Provinsi</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="city_id" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                                    <select id="city_id" name="city_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" disabled>
                                        <option value="">Pilih Provinsi Dahulu</option>
                                    </select>
                                    <div class="text-red-500 text-xs mt-1 hidden" id="city_error">Gagal memuat data kota.</div>
                                </div>
                                <div>
                                    <label for="alamat_lengkap" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                    <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">{{ old('alamat_lengkap') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Gambar Produk -->
                    <div class="bg-white p-8 rounded-xl shadow-md">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-4">Gambar Utama Produk</h2>
                        <div id="dropzone-container" class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md cursor-pointer hover:border-orange-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <div id="preview-wrapper" class="hidden">
                                    <img id="preview" src="#" alt="Preview Gambar" class="mx-auto h-32 w-auto rounded-md">
                                    <p id="filename-display" class="text-sm text-gray-500 mt-2"></p>
                                </div>
                                <div id="placeholder-wrapper">
                                    <i class="fas fa-cloud-upload-alt mx-auto h-12 w-12 text-gray-400"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="gambar" class="relative font-medium text-orange-600 hover:text-orange-500">
                                            <span>Unggah file</span>
                                            <input id="gambar" name="gambar" type="file" required class="sr-only">
                                        </label>
                                        <p class="pl-1">atau seret dan lepas</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                </div>
                            </div>
                        </div>
                        @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Card Ukuran & Harga -->
                    <div class="bg-white p-8 rounded-xl shadow-md">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-4">Ukuran, Harga, dan Stok</h2>
                        <div class="space-y-4">
                            @php $availableSizes = ['S', 'M', 'L', 'XL']; @endphp
                            @foreach($availableSizes as $sizeName)
                                <div class="border rounded-lg" id="card_{{ $sizeName }}">
                                    <div class="flex items-center justify-between p-4 cursor-pointer" onclick="document.getElementById('toggle_{{ $sizeName }}').click()">
                                        <label class="flex items-center gap-3 text-base font-semibold text-gray-800">
                                            <input type="checkbox" name="size_active[{{ $sizeName }}]" id="toggle_{{ $sizeName }}" onchange="toggleSize('{{ $sizeName }}')" class="h-5 w-5 rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                            Ukuran {{ $sizeName }}
                                        </label>
                                        <span id="status_{{ $sizeName }}" class="text-xs font-medium px-2.5 py-1 rounded-full bg-gray-200 text-gray-800">Tidak Aktif</span>
                                    </div>
                                    <div id="size_details_{{ $sizeName }}" class="p-4 border-t border-gray-200" style="display: none;">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="harga_{{ $sizeName }}" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                                                <input type="number" name="sizes[{{ $sizeName }}][harga]" id="harga_{{ $sizeName }}" value="{{ old('sizes.'.$sizeName.'.harga') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="50000">
                                                <div class="text-red-500 text-xs mt-1 hidden" id="harga_feedback_{{ $sizeName }}">Harga wajib diisi.</div>
                                            </div>
                                            <div>
                                                <label for="stock_{{ $sizeName }}" class="block text-sm font-medium text-gray-700">Stok</label>
                                                <input type="number" name="sizes[{{ $sizeName }}][stock]" id="stock_{{ $sizeName }}" value="{{ old('sizes.'.$sizeName.'.stock') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="10">
                                                <div class="text-red-500 text-xs mt-1 hidden" id="stock_feedback_{{ $sizeName }}">Stok wajib diisi.</div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700">Gambar Ukuran (Wajib)</label>
                                            <input type="file" name="sizes[{{ $sizeName }}][gambar]" id="gambar_{{ $sizeName }}" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end gap-4 pt-4 border-t">
                        <a href="{{ route('seller.products') }}" class="bg-white border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="bg-orange-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-orange-600 transition-colors">
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Salin dan tempel SELURUH JavaScript dari file lamamu ke sini.
    // Kode ini dirancang untuk bekerja dengan ID dan kelas yang sudah disamakan.
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Province-City functionality
        const provinceSelect = document.getElementById('province_id');
        const citySelect = document.getElementById('city_id');
        const cityError = document.getElementById('city_error');
        
        provinceSelect.addEventListener('change', function() {
            const provinceId = this.value;
            citySelect.innerHTML = '<option value="">Memuat...</option>';
            citySelect.disabled = true;
            cityError.style.display = 'none';
            
            if (provinceId) {
                fetch(`/api/cities/${provinceId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                        citySelect.disabled = false;
                    } else {
                        citySelect.innerHTML = '<option value="">Tidak ada kota ditemukan</option>';
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    citySelect.innerHTML = '<option value="">Error memuat kota</option>';
                    cityError.textContent = 'Gagal memuat data kota. Coba lagi.';
                    cityError.style.display = 'block';
                });
            } else {
                citySelect.innerHTML = '<option value="">Pilih provinsi terlebih dahulu</option>';
            }
        });
        
        // Main product image upload
        const dropzone = document.getElementById('dropzone-container');
        const mainFileInput = document.getElementById('gambar');
        const mainPreview = document.getElementById('preview');
        const previewWrapper = document.getElementById('preview-wrapper');
        const placeholderWrapper = document.getElementById('placeholder-wrapper');
        const filenameDisplay = document.getElementById('filename-display');
        
        dropzone.addEventListener('click', () => mainFileInput.click());
        mainFileInput.addEventListener('change', (e) => previewImage(e.target, 'preview'));

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => dropzone.classList.add('border-orange-400', 'bg-orange-50'), false);
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => dropzone.classList.remove('border-orange-400', 'bg-orange-50'), false);
        });
        dropzone.addEventListener('drop', (e) => {
            mainFileInput.files = e.dataTransfer.files;
            mainFileInput.dispatchEvent(new Event('change'));
        }, false);

        // Form validation on submit
        document.getElementById('productForm').addEventListener('submit', function(e) {
            const activeSizes = document.querySelectorAll('input[name^="size_active"]:checked');
            let isValid = true;
            
            if (activeSizes.length === 0) {
                e.preventDefault();
                alert('Mohon pilih dan aktifkan minimal satu ukuran.');
                return;
            }
            
            activeSizes.forEach(checkbox => {
                const size = checkbox.id.replace('toggle_', '');
                const hargaInput = document.getElementById(`harga_${size}`);
                const stockInput = document.getElementById(`stock_${size}`);
                
                if (!hargaInput.value || hargaInput.value <= 0) {
                    isValid = false;
                    hargaInput.classList.add('border-red-500');
                    document.getElementById(`harga_feedback_${size}`).classList.remove('hidden');
                } else {
                    hargaInput.classList.remove('border-red-500');
                    document.getElementById(`harga_feedback_${size}`).classList.add('hidden');
                }
                
                if (!stockInput.value || stockInput.value < 0) {
                    isValid = false;
                    stockInput.classList.add('border-red-500');
                    document.getElementById(`stock_feedback_${size}`).classList.remove('hidden');
                } else {
                    stockInput.classList.remove('border-red-500');
                    document.getElementById(`stock_feedback_${size}`).classList.add('hidden');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua data harga dan stok untuk ukuran yang dipilih.');
            }
        });
    });

    function toggleSize(size) {
        const details = document.getElementById(`size_details_${size}`);
        const toggle = document.getElementById(`toggle_${size}`);
        const card = document.getElementById(`card_${size}`);
        const statusBadge = document.getElementById(`status_${size}`);
        
        if (toggle.checked) {
            details.style.display = 'block';
            card.classList.add('bg-orange-50', 'border-orange-200');
            statusBadge.textContent = 'Aktif';
            statusBadge.classList.remove('bg-gray-200', 'text-gray-800');
            statusBadge.classList.add('bg-green-100', 'text-green-800');
        } else {
            details.style.display = 'none';
            card.classList.remove('bg-orange-50', 'border-orange-200');
            statusBadge.textContent = 'Tidak Aktif';
            statusBadge.classList.remove('bg-green-100', 'text-green-800');
            statusBadge.classList.add('bg-gray-200', 'text-gray-800');
        }
    }

    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const previewWrapper = document.getElementById('preview-wrapper');
        const placeholderWrapper = document.getElementById('placeholder-wrapper');
        const filenameDisplay = document.getElementById('filename-display');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewWrapper.classList.remove('hidden');
                placeholderWrapper.classList.add('hidden');
                filenameDisplay.textContent = input.files[0].name;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection