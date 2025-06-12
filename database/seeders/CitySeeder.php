<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Province;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Jawa Timur' => [
                'Surabaya', 'Malang', 'Kediri', 'Blitar', 'Mojokerto', 
                'Madiun', 'Pasuruan', 'Probolinggo', 'Batu', 'Sidoarjo',
                'Gresik', 'Lamongan', 'Bojonegoro', 'Tuban', 'Jombang',
                'Nganjuk', 'Magetan', 'Ponorogo', 'Pacitan', 'Trenggalek',
                'Tulungagung', 'Lumajang', 'Jember', 'Bondowoso', 'Situbondo',
                'Banyuwangi', 'Bangkalan', 'Sampang', 'Pamekasan', 'Sumenep'
            ],
            'Jawa Tengah' => [
                'Semarang', 'Surakarta', 'Magelang', 'Salatiga',
                'Pekalongan', 'Tegal', 'Kudus', 'Demak', 'Jepara',
                'Rembang', 'Blora', 'Grobogan', 'Kendal', 'Temanggung',
                'Wonosobo', 'Purworejo', 'Kebumen', 'Banjarnegara', 'Cilacap',
                'Banyumas', 'Purbalingga', 'Pemalang', 'Batang', 'Pati',
                'Klaten', 'Boyolali', 'Sragen', 'Karanganyar', 'Wonogiri',
                'Sukoharjo', 'Brebes', 'Tegal'
            ],
            'Jawa Barat' => [
                'Bandung', 'Bekasi', 'Depok', 'Bogor', 'Cimahi',
                'Tasikmalaya', 'Banjar', 'Cirebon', 'Sukabumi', 'Garut',
                'Cianjur', 'Kuningan', 'Majalengka', 'Sumedang', 'Indramayu',
                'Subang', 'Purwakarta', 'Karawang', 'Pangandaran'
            ],
            'DKI Jakarta' => [
                'Jakarta Pusat', 'Jakarta Utara', 'Jakarta Barat', 'Jakarta Selatan',
                'Jakarta Timur', 'Kepulauan Seribu'
            ],
            'Banten' => [
                'Serang', 'Tangerang', 'Cilegon', 'Tangerang Selatan',
                'Lebak', 'Pandeglang'
            ],
            'DI Yogyakarta' => [
                'Yogyakarta', 'Bantul', 'Sleman', 'Kulon Progo', 'Gunung Kidul'
            ],
            'Sumatera Utara' => [
                'Medan', 'Binjai', 'Tebing Tinggi', 'Pematangsiantar', 'Tanjungbalai',
                'Sibolga', 'Padang Sidempuan', 'Gunungsitoli', 'Deli Serdang',
                'Langkat', 'Karo', 'Simalungun', 'Asahan', 'Labuhanbatu',
                'Dairi', 'Toba Samosir', 'Mandailing Natal', 'Nias', 'Pakpak Bharat',
                'Humbang Hasundutan', 'Samosir', 'Serdang Bedagai', 'Batu Bara',
                'Padang Lawas Utara', 'Padang Lawas', 'Labuhanbatu Selatan',
                'Labuhanbatu Utara', 'Nias Selatan', 'Nias Utara', 'Nias Barat'
            ],
            'Sumatera Barat' => [
                'Padang', 'Bukittinggi', 'Padangpanjang', 'Pariaman', 'Payakumbuh',
                'Sawahlunto', 'Solok', 'Agam', 'Dharmasraya', 'Kepulauan Mentawai',
                'Lima Puluh Kota', 'Padang Pariaman', 'Pasaman', 'Pasaman Barat',
                'Pesisir Selatan', 'Sijunjung', 'Solok Selatan', 'Tanah Datar'
            ],
            'Sumatera Selatan' => [
                'Palembang', 'Prabumulih', 'Pagar Alam', 'Lubuklinggau',
                'Banyuasin', 'Empat Lawang', 'Lahat', 'Muara Enim',
                'Musi Banyuasin', 'Musi Rawas', 'Musi Rawas Utara', 'Ogan Ilir',
                'Ogan Komering Ilir', 'Ogan Komering Ulu', 'Ogan Komering Ulu Selatan',
                'Ogan Komering Ulu Timur'
            ],
            'Riau' => [
                'Pekanbaru', 'Dumai', 'Bengkalis', 'Indragiri Hilir',
                'Indragiri Hulu', 'Kampar', 'Kepulauan Meranti', 'Kuantan Singingi',
                'Pelalawan', 'Rokan Hilir', 'Rokan Hulu', 'Siak'
            ],
            'Jambi' => [
                'Jambi', 'Sungai Penuh', 'Batang Hari', 'Bungo',
                'Kerinci', 'Merangin', 'Muaro Jambi', 'Sarolangun',
                'Tanjung Jabung Barat', 'Tanjung Jabung Timur', 'Tebo'
            ],
            'Bengkulu' => [
                'Bengkulu', 'Bengkulu Selatan', 'Bengkulu Tengah', 'Bengkulu Utara',
                'Kaur', 'Kepahiang', 'Lebong', 'Mukomuko', 'Rejang Lebong',
                'Seluma'
            ],
            'Lampung' => [
                'Bandar Lampung', 'Metro', 'Lampung Barat', 'Lampung Selatan',
                'Lampung Tengah', 'Lampung Timur', 'Lampung Utara', 'Mesuji',
                'Pesawaran', 'Pesisir Barat', 'Pringsewu', 'Tanggamus',
                'Tulang Bawang', 'Tulang Bawang Barat', 'Way Kanan'
            ],
            'Kepulauan Bangka Belitung' => [
                'Pangkalpinang', 'Bangka', 'Bangka Barat', 'Bangka Selatan',
                'Bangka Tengah', 'Belitung', 'Belitung Timur'
            ],
            'Kepulauan Riau' => [
                'Batam', 'Tanjungpinang', 'Bintan', 'Karimun',
                'Kepulauan Anambas', 'Lingga', 'Natuna'
            ],
            'Aceh' => [
                'Banda Aceh', 'Langsa', 'Lhokseumawe', 'Sabang', 'Subulussalam',
                'Aceh Barat', 'Aceh Barat Daya', 'Aceh Besar', 'Aceh Jaya',
                'Aceh Selatan', 'Aceh Singkil', 'Aceh Tamiang', 'Aceh Tengah',
                'Aceh Tenggara', 'Aceh Timur', 'Aceh Utara', 'Bener Meriah',
                'Bireuen', 'Gayo Lues', 'Nagan Raya', 'Pidie', 'Pidie Jaya',
                'Simeulue'
            ],
            'Kalimantan Barat' => [
                'Pontianak', 'Singkawang', 'Bengkayang', 'Kapuas Hulu',
                'Kayong Utara', 'Ketapang', 'Kubu Raya', 'Landak',
                'Melawi', 'Sambas', 'Sanggau', 'Sekadau', 'Sintang'
            ],
            'Kalimantan Tengah' => [
                'Palangka Raya', 'Barito Selatan', 'Barito Timur', 'Barito Utara',
                'Gunung Mas', 'Kapuas', 'Katingan', 'Kotawaringin Barat',
                'Kotawaringin Timur', 'Lamandau', 'Murung Raya', 'Pulang Pisau',
                'Sukamara', 'Seruyan'
            ],
            'Kalimantan Selatan' => [
                'Banjarmasin', 'Banjarbaru', 'Balangan', 'Banjar',
                'Barito Kuala', 'Hulu Sungai Selatan', 'Hulu Sungai Tengah',
                'Hulu Sungai Utara', 'Kotabaru', 'Tabalong', 'Tanah Bumbu',
                'Tanah Laut', 'Tapin'
            ],
            'Kalimantan Timur' => [
                'Samarinda', 'Balikpapan', 'Bontang', 'Berau',
                'Kutai Barat', 'Kutai Kartanegara', 'Kutai Timur',
                'Mahakam Ulu', 'Paser', 'Penajam Paser Utara'
            ],
            'Kalimantan Utara' => [
                'Tarakan', 'Bulungan', 'Malinau', 'Nunukan', 'Tana Tidung'
            ],
            'Sulawesi Utara' => [
                'Manado', 'Bitung', 'Tomohon', 'Kotamobagu', 'Bolaang Mongondow',
                'Bolaang Mongondow Selatan', 'Bolaang Mongondow Timur',
                'Bolaang Mongondow Utara', 'Kepulauan Sangihe', 'Kepulauan Siau Tagulandang Biaro',
                'Kepulauan Talaud', 'Minahasa', 'Minahasa Selatan', 'Minahasa Tenggara',
                'Minahasa Utara'
            ],
            'Sulawesi Tengah' => [
                'Palu', 'Banggai', 'Banggai Kepulauan', 'Banggai Laut',
                'Buol', 'Donggala', 'Morowali', 'Morowali Utara',
                'Parigi Moutong', 'Poso', 'Sigi', 'Tojo Una-Una', 'Tolitoli'
            ],
            'Sulawesi Selatan' => [
                'Makassar', 'Parepare', 'Palopo', 'Bantaeng', 'Barru',
                'Bone', 'Bulukumba', 'Enrekang', 'Gowa', 'Jeneponto',
                'Kepulauan Selayar', 'Luwu', 'Luwu Timur', 'Luwu Utara',
                'Maros', 'Pangkajene dan Kepulauan', 'Pinrang', 'Sidenreng Rappang',
                'Sinjai', 'Soppeng', 'Takalar', 'Tana Toraja', 'Toraja Utara',
                'Wajo'
            ],
            'Sulawesi Tenggara' => [
                'Kendari', 'Bau-Bau', 'Bombana', 'Buton', 'Buton Selatan',
                'Buton Tengah', 'Buton Utara', 'Kolaka', 'Kolaka Timur',
                'Kolaka Utara', 'Konawe', 'Konawe Kepulauan', 'Konawe Selatan',
                'Konawe Utara', 'Muna', 'Muna Barat', 'Wakatobi'
            ],
            'Gorontalo' => [
                'Gorontalo', 'Boalemo', 'Bone Bolango', 'Gorontalo Utara',
                'Pohuwato'
            ],
            'Sulawesi Barat' => [
                'Mamuju', 'Majene', 'Mamasa', 'Mamuju Tengah', 'Mamuju Utara',
                'Polewali Mandar'
            ],
            'Bali' => [
                'Denpasar', 'Badung', 'Gianyar', 'Tabanan', 'Klungkung',
                'Bangli', 'Karangasem', 'Buleleng', 'Jembrana'
            ],
            'Nusa Tenggara Barat' => [
                'Mataram', 'Bima', 'Bima', 'Dompu', 'Lombok Barat',
                'Lombok Tengah', 'Lombok Timur', 'Lombok Utara', 'Sumbawa',
                'Sumbawa Barat'
            ],
            'Nusa Tenggara Timur' => [
                'Kupang', 'Alor', 'Belu', 'Ende', 'Flores Timur',
                'Kupang', 'Lembata', 'Manggarai', 'Manggarai Barat', 'Manggarai Timur',
                'Nagekeo', 'Ngada', 'Rote Ndao', 'Sabu Raijua', 'Sikka',
                'Sumba Barat', 'Sumba Barat Daya', 'Sumba Tengah', 'Sumba Timur',
                'Timor Tengah Selatan', 'Timor Tengah Utara'
            ],
            'Maluku' => [
                'Ambon', 'Tual', 'Buru', 'Buru Selatan', 'Kepulauan Aru',
                'Maluku Barat Daya', 'Maluku Tengah', 'Maluku Tenggara',
                'Maluku Tenggara Barat', 'Seram Bagian Barat', 'Seram Bagian Timur'
            ],
            'Maluku Utara' => [
                'Ternate', 'Tidore Kepulauan', 'Halmahera Barat', 'Halmahera Selatan',
                'Halmahera Tengah', 'Halmahera Timur', 'Halmahera Utara',
                'Kepulauan Sula', 'Pulau Morotai', 'Pulau Taliabu'
            ],
            'Papua' => [
                'Jayapura', 'Asmat', 'Biak Numfor', 'Boven Digoel',
                'Deiyai', 'Dogiyai', 'Intan Jaya', 'Jayapura', 'Jayawijaya',
                'Keerom', 'Kepulauan Yapen', 'Lanny Jaya', 'Mamberamo Raya',
                'Mamberamo Tengah', 'Mappi', 'Merauke', 'Mimika', 'Nabire',
                'Nduga', 'Paniai', 'Pegunungan Bintang', 'Puncak', 'Puncak Jaya',
                'Sarmi', 'Supiori', 'Tolikara', 'Waropen', 'Yahukimo', 'Yalimo'
            ],
            'Papua Barat' => [
                'Manokwari', 'Sorong', 'Fakfak', 'Kaimana', 'Manokwari Selatan',
                'Maybrat', 'Pegunungan Arfak', 'Raja Ampat', 'Sorong Selatan',
                'Tambrauw', 'Teluk Bintuni', 'Teluk Wondama'
            ]
        ];

        foreach ($cities as $provinceName => $cityList) {
            $province = Province::where('name', $provinceName)->first();
            
            if ($province) {
                foreach ($cityList as $cityName) {
                    City::create([
                        'province_id' => $province->id,
                        'name' => $cityName
                    ]);
                }
            }
        }
    }
}