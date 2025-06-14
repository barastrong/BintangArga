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
                    <h1 class="text-3xl font-bold text-gray-800">Edit Produk</h1>
                    <p class="text-gray-500 mt-1">Perbarui informasi produk Anda di bawah ini.</p>
                </div>

                {{-- Menampilkan error validasi --}}
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

                {{-- Form utama yang membungkus semuanya, sesuai struktur aslimu --}}
                <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" id="productForm" class="space-y-8">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="seller_id" value="{{ $seller->id }}">

                    <!-- Card Informasi Produk -->
                    <div class="bg-white p-8 rounded-xl shadow-md">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-4">Informasi Produk</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                                <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang', $product->nama_barang) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            </div>
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select id="category_id" name="category_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea id="description" name="description" rows="4" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Card Lokasi -->
                    <div class="bg-white p-8 rounded-xl shadow-md">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-4">Lokasi Toko</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="province_id" class="block text-sm font-medium text-gray-700">Provinsi</label>
                                <select id="province_id" name="province_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id', $product->province_id) == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="city_id" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                                <select id="city_id" name="city_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <option value="">Pilih Kota/Kabupaten</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id', $product->city_id) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-6">
                            <label for="alamat_lengkap" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                            <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">{{ old('alamat_lengkap', $product->alamat_lengkap) }}</textarea>
                        </div>
                    </div>

                    <!-- Card Gambar Produk -->
                    <div class="bg-white p-8 rounded-xl shadow-md">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-4">Gambar Produk</h2>
                        <div class="flex items-start gap-4">
                            <img id="imagePreview" src="{{ $product->gambar ? asset('storage/' . $product->gambar) : 'https://via.placeholder.com/150' }}" alt="Preview" class="w-32 h-32 rounded-lg object-cover">
                            <div>
                                <input type="file" name="gambar" id="gambar" class="hidden" onchange="previewMainImage(event)">
                                <label for="gambar" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Pilih Gambar
                                </label>
                                <p class="text-xs text-gray-500 mt-2">JPG, PNG, atau GIF (Maks. 2MB)</p>
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
                                @php $sizeData = $product->sizes->where('size', $sizeName)->first(); @endphp
                                <div class="border rounded-lg p-4 {{ $sizeData ? 'bg-orange-50 border-orange-200' : 'bg-gray-50' }}" x-data="{ open: {{ $sizeData ? 'true' : 'false' }} }">
                                    <div @click="open = !open" class="flex items-center justify-between cursor-pointer">
                                        <label class="flex items-center gap-3 text-base font-semibold text-gray-800">
                                            <input type="checkbox" name="size_active[{{ $sizeName }}]" class="h-5 w-5 rounded border-gray-300 text-orange-600 focus:ring-orange-500" {{ $sizeData ? 'checked' : '' }}>
                                            Ukuran {{ $sizeName }}
                                        </label>
                                        <i class="fas fa-chevron-down transition-transform" :class="{'rotate-180': open}"></i>
                                    </div>
                                    <div x-show="open" x-transition class="mt-4 space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="sizes_{{ $sizeName }}_harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                                                <input type="number" name="sizes[{{ $sizeName }}][harga]" value="{{ old('sizes.'.$sizeName.'.harga', $sizeData->harga ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="50000">
                                            </div>
                                            <div>
                                                <label for="sizes_{{ $sizeName }}_stock" class="block text-sm font-medium text-gray-700">Stok</label>
                                                <input type="number" name="sizes[{{ $sizeName }}][stock]" value="{{ old('sizes.'.$sizeName.'.stock', $sizeData->stock ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="10">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Gambar Ukuran (Opsional)</label>
                                            <div class="mt-2 flex items-center gap-4">
                                                <img id="size_preview_{{ $sizeName }}" src="{{ $sizeData && $sizeData->gambar_size ? asset('storage/' . $sizeData->gambar_size) : 'https://via.placeholder.com/100x100.png?text=No+Image' }}" class="h-16 w-16 rounded-md object-cover">
                                                <input type="file" name="sizes[{{ $sizeName }}][gambar]" id="size_input_{{ $sizeName }}" class="hidden" onchange="previewSizeImage(event, '{{ $sizeName }}')">
                                                <label for="size_input_{{ $sizeName }}" class="cursor-pointer bg-white py-1.5 px-2.5 border border-gray-300 rounded-md shadow-sm text-xs leading-4 font-medium text-gray-700 hover:bg-gray-50">
                                                    Ganti
                                                </label>
                                            </div>
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
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview untuk gambar utama produk
    function previewMainImage(event) {
        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(){
                document.getElementById('imagePreview').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    // Preview untuk gambar spesifik ukuran
    function previewSizeImage(event, sizeName) {
        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(){
                document.getElementById(`size_preview_${sizeName}`).src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    // Dropdown Lokasi
    document.addEventListener('DOMContentLoaded', function() {
        const provinceSelect = document.getElementById('province_id');
        const citySelect = document.getElementById('city_id');
        const oldCityId = "{{ old('city_id', $product->city_id) }}";

        function fetchCities(provinceId, selectedCityId = null) {
            citySelect.innerHTML = '<option value="">Memuat kota...</option>';
            if (!provinceId) {
                citySelect.innerHTML = '<option value="">Pilih Provinsi Dahulu</option>';
                return;
            }
            fetch(`/api/cities/${provinceId}`)
                .then(response => response.json())
                .then(cities => {
                    citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        if (city.id == selectedCityId) {
                            option.selected = true;
                        }
                        citySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching cities:', error));
        }

        if (provinceSelect.value) {
            fetchCities(provinceSelect.value, oldCityId);
        }
        provinceSelect.addEventListener('change', () => fetchCities(provinceSelect.value));
    });
</script>
@endsection