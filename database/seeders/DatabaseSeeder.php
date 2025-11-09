<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

     
    public function run(): void
    {
        $this->call([
            ProvinceSeeder::class,
            CitySeeder::class,
            CategorySeeder::class,
        ]);

        // Seeder 1 user admin tanpa foto profil
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'Test@gmail.com',
            'password' => Hash::make('HelloWorld'),
            'role' => 'admin',
        ]);
    }
}
