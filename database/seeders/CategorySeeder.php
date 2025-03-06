<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nama' => 'Kaos', 
                'gambar' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVJAp8ADg6ri4Kdo3vRHqfJps74wCIoFad7A&s'
            ],
            [
                'nama' => 'Kemeja', 
                'gambar' => 'https://www.uniqlo.com/id/en/news/sp/topics/2023112201/img/mimg_1_l.jpg'
            ],
            [
                'nama' => 'Celana', 
                'gambar' => 'https://images.tokopedia.net/img/cache/700/VqbcmM/2024/7/16/1c7b3d7c-3947-4d50-a960-fb40a1005a94.jpg'
            ],
            [
                'nama' => 'Jaket', 
                'gambar' => 'https://ozzakonveksi.com/wp-content/uploads/2022/01/jaket-bomber-custom-himpunan-mahasiswa-UGM.jpg'
            ],
            [
                'nama' => 'Gaun', 
                'gambar' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAXF0xGhIS9J-5I8XzYaBT8nIIGaqpozUh4w&s'
            ],
            [
                'nama' => 'Sweater', 
                'gambar' => 'https://media.istockphoto.com/id/1278802435/photo/sweater-yellow-color-isolated-on-white-trendy-womens-clothing-knitted-apparel.jpg?s=612x612&w=0&k=20&c=FQkuYEwpizIULWpcN0kjOwoe0mZZKFVZzxpmpP0rKlI='
            ],
            [
                'nama' => 'Hoodie', 
                'gambar' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT9SULAixRoC6PPNW_j4q8d3A6d-6Hg_8znqQ&s'
            ],
            [
                'nama' => 'Rok', 
                'gambar' => 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//108/MTA-93896080/no-brand_no-brand_full01.jpg'
            ],
            [
                'nama' => 'Blazer', 
                'gambar' => 'https://mukimlamteungoh.id/wp-content/uploads/2019/11/shop_06-4.jpg'
            ],
            [
                'nama' => 'Jumpsuit', 
                'gambar' => 'https://n.nordstrommedia.com/id/sr3/f3d1e92e-7ca8-4393-a951-c14dd98587fb.jpeg?h=365&w=240&dpr=2'
            ]
        ];
        
    
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
