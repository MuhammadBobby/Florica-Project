<?php

namespace Database\Seeders;

use App\Models\ShippingRegion;
use Illuminate\Database\Seeder;

class ShippingRegionSeeder extends Seeder
{
    public function run(): void
    {
        ShippingRegion::insert([
            [
                'region_name' => 'Medan Kota',
                'shipping_cost' => 10000,
                'estimated_delivery' => '1 Hari',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'region_name' => 'Medan Barat',
                'shipping_cost' => 15000,
                'estimated_delivery' => '1 Hari',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'region_name' => 'Deli Serdang',
                'shipping_cost' => 25000,
                'estimated_delivery' => '1-2 Hari',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
