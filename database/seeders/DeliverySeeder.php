<?php

// database/seeders/DeliverySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Delivery;

class DeliverySeeder extends Seeder
{
    public function run()
    {
        $deliveries = [
            [
                'nama' => 'Ahmad Kurniawan',
                'no_telepon' => '081234567890',
                'email' => 'ahmad.kurniawan@delivery.com',
                'foto_profile' => null,
            ],
            [
                'nama' => 'Budi Santoso',
                'no_telepon' => '081234567891',
                'email' => 'budi.santoso@delivery.com',
                'foto_profile' => null,
            ],
            [
                'nama' => 'Citra Dewi',
                'no_telepon' => '081234567892',
                'email' => 'citra.dewi@delivery.com',
                'foto_profile' => null,
            ],
            [
                'nama' => 'Doni Pratama',
                'no_telepon' => '081234567893',
                'email' => 'doni.pratama@delivery.com',
                'foto_profile' => null,
            ],
            [
                'nama' => 'Eka Susanti',
                'no_telepon' => '081234567894',
                'email' => 'eka.susanti@delivery.com',
                'foto_profile' => null,
            ],
            [
                'nama' => 'Fajar Ramadhan',
                'no_telepon' => '081234567895',
                'email' => 'fajar.ramadhan@delivery.com',
                'foto_profile' => null,
            ],
            [
                'nama' => 'Gita Maharani',
                'no_telepon' => '081234567896',
                'email' => 'gita.maharani@delivery.com',
                'foto_profile' => null,
            ],
            [
                'nama' => 'Hadi Wijaya',
                'no_telepon' => '081234567897',
                'email' => 'hadi.wijaya@delivery.com',
                'foto_profile' => null,
            ],
            [
                'nama' => 'Indah Permata',
                'no_telepon' => '081234567898',
                'email' => 'indah.permata@delivery.com',
                'foto_profile' => null,
            ],
            [
                'nama' => 'Joko Susilo',
                'no_telepon' => '081234567899',
                'email' => 'joko.susilo@delivery.com',
                'foto_profile' => null,
            ]
        ];

        foreach ($deliveries as $delivery) {
            Delivery::create($delivery);
        }
    }
}