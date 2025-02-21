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
            ['nama' => 'Kaos', 
            'gambar' => 'https://www.realsimple.com/thmb/T8Ep_MPA7CDhtGJ-C2V32yDvD3A=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/reuse-old-clothes-gettyimages-1316931901-e574c71950ed47c7a9bcce3d1c7911a0.jpg'
            ],
            ['nama' => 'Kemeja', 'gambar' => 'https://www.realsimple.com/thmb/T8Ep_MPA7CDhtGJ-C2V32yDvD3A=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/reuse-old-clothes-gettyimages-1316931901-e574c71950ed47c7a9bcce3d1c7911a0.jpg'],
            ['nama' => 'Celana', 'gambar' => 'https://www.realsimple.com/thmb/T8Ep_MPA7CDhtGJ-C2V32yDvD3A=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/reuse-old-clothes-gettyimages-1316931901-e574c71950ed47c7a9bcce3d1c7911a0.jpg'],
            ['nama' => 'Jaket', 'gambar' => 'https://www.realsimple.com/thmb/T8Ep_MPA7CDhtGJ-C2V32yDvD3A=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/reuse-old-clothes-gettyimages-1316931901-e574c71950ed47c7a9bcce3d1c7911a0.jpg'],
            ['nama' => 'Dress', 'gambar' => 'https://www.realsimple.com/thmb/T8Ep_MPA7CDhtGJ-C2V32yDvD3A=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/reuse-old-clothes-gettyimages-1316931901-e574c71950ed47c7a9bcce3d1c7911a0.jpg']
        ];
    
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
