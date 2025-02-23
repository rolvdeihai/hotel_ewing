<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rooms;
use App\Models\Saldo;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Bos',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('1234567890'),
        ]);

        User::factory()->create([
            'name' => 'Pegawai',
            'email' => 'employee@gmail.com',
            'role' => 'user',
            'password' => Hash::make('1234567890'),
        ]);

        Rooms::factory()->create([
            'room_number' => '001',
            'price_per_night' => 200000,
            'status' => 'vacant',
        ]);

        Rooms::factory()->create([
            'room_number' => '002',
            'price_per_night' => 200000,
            'status' => 'vacant',
        ]);

        Rooms::factory()->create([
            'room_number' => '003',
            'price_per_night' => 200000,
            'status' => 'vacant',
        ]);

        Rooms::factory()->create([
            'room_number' => '004',
            'price_per_night' => 200000,
            'status' => 'vacant',
        ]);

        Rooms::factory()->create([
            'room_number' => '005',
            'price_per_night' => 200000,
            'status' => 'vacant',
        ]);

        Rooms::factory()->create([
            'room_number' => '006',
            'price_per_night' => 200000,
            'status' => 'vacant',
        ]);

        Saldo::factory()->create([
            'saldo' => 0,
            'room_rate' => 200000,
            'tax' => 0.15,
        ]);
    }
}
