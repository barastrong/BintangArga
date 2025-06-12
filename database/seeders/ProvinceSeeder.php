<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            'Jawa Timur',
            'Jawa Tengah', 
            'Jawa Barat',
            'DKI Jakarta',
            'Banten',
            'DI Yogyakarta',
            'Sumatera Utara',
            'Sumatera Barat',
            'Sumatera Selatan',
            'Riau',
            'Jambi',
            'Bengkulu',
            'Lampung',
            'Kepulauan Bangka Belitung',
            'Kepulauan Riau',
            'Aceh',
            'Kalimantan Barat',
            'Kalimantan Tengah',
            'Kalimantan Selatan',
            'Kalimantan Timur',
            'Kalimantan Utara',
            'Sulawesi Utara',
            'Sulawesi Tengah',
            'Sulawesi Selatan',
            'Sulawesi Tenggara',
            'Gorontalo',
            'Sulawesi Barat',
            'Bali',
            'Nusa Tenggara Barat',
            'Nusa Tenggara Timur',
            'Maluku',
            'Maluku Utara',
            'Papua',
            'Papua Barat'
        ];

        foreach ($provinces as $province) {
            Province::create([
                'name' => $province
            ]);
        }
    }
}