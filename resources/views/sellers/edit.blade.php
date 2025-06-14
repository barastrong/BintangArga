@extends('layouts.app')

@section('content')
<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Kolom Sidebar -->
            <div class="lg:col-span-1">
                @include('sellers.partials.sidebar')
            </div>

            <!-- Kolom Konten Utama -->
            <div class="lg:col-span-3 space-y-8">
                <h1 class="text-3xl font-bold text-gray-800">Edit Profil Penjual</h1>

                <!-- Card untuk Update Informasi Profil -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold text-gray-800">Informasi Toko</h2>
                        <p class="text-sm text-gray-500 mt-1">Perbarui nama toko, email, dan foto profil Anda.</p>
                    </div>
                    <form method="POST" action="{{ route('seller.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="p-6 space-y-6">
                            <!-- Upload Foto -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Foto Profil</label>
                                <div class="mt-2 flex items-center gap-4">
                                    <img id="profilePreview" 
                                         src="{{ $seller->foto_profil ? asset('storage/' . $seller->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode($seller->nama_penjual).'&color=FFFFFF&background=F97316&size=128' }}" 
                                         alt="Foto Profil" 
                                         class="h-20 w-20 rounded-full object-cover">
                                    <input type="file" name="foto_profil" id="foto_profil" class="hidden" onchange="previewImage(event)">
                                    <label for="foto_profil" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50">
                                        Ganti Foto
                                    </label>
                                </div>
                                @error('foto_profil') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Nama Penjual -->
                            <div>
                                <label for="nama_penjual" class="block text-sm font-medium text-gray-700">Nama Toko / Penjual</label>
                                <input type="text" name="nama_penjual" id="nama_penjual" value="{{ old('nama_penjual', $seller->nama_penjual) }}" required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                @error('nama_penjual') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email Penjual -->
                            <div>
                                <label for="email_penjual" class="block text-sm font-medium text-gray-700">Email Kontak Toko</label>
                                <input type="email" name="email_penjual" id="email_penjual" value="{{ old('email_penjual', $seller->email_penjual) }}" required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                @error('email_penjual') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label for="no_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon (Opsional)</label>
                                <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $seller->no_telepon) }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                @error('no_telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="p-6 bg-gray-50 text-right">
                            <button type="submit" class="bg-orange-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-orange-600 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Card Hapus Akun -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold text-red-600">Zona Berbahaya</h2>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Hapus Akun Penjual</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Setelah akun Anda dihapus, semua produk dan data penjualan akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
                        </p>
                        <button 
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-seller-deletion')"
                            class="mt-4 inline-flex items-center gap-2 bg-red-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash-alt"></i>
                            Hapus Akun Ini
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus (Menggunakan Komponen Blade Laravel) -->
<x-modal name="confirm-seller-deletion" focusable>
    <form method="post" action="{{ route('seller.destroy', $seller->id) }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900">
            Apakah Anda yakin ingin menghapus akun penjual Anda?
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Tindakan ini akan menghapus semua produk dan data penjualan Anda secara permanen.
        </p>

        <div class="mt-6 flex justify-end">
            <button type="button" x-on:click="$dispatch('close')" class="bg-white border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md hover:bg-gray-50 transition-colors">
                Batal
            </button>

            <button type="submit" class="ml-3 bg-red-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-red-700 transition-colors">
                Ya, Hapus Akun
            </button>
        </div>
    </form>
</x-modal>

<script>
    // Script sederhana untuk preview gambar
    function previewImage(event) {
        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('profilePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection