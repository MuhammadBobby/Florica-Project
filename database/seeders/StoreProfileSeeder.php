<?php

namespace Database\Seeders;

use App\Models\StoreProfile;
use Illuminate\Database\Seeder;

class StoreProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoreProfile::create([
            'store_name' => 'Florica Blooms',

            'phone' => '081959000065',

            'whatsapp' => '081959000065',

            'email' => 'floricablooms@gmail.com',

            'address' => 'Jl. Besar Delitua, Sumatera Utara',

            'latitude' => 3.5200000,
            'longitude' => 98.7100000,

            'district' => 'Delitua',
            'city' => 'Medan',
            'province' => 'Sumatera Utara',

            'description' => 'Florica Blooms Flower & Gift Shop',
        ]);
    }
}
