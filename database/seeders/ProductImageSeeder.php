<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        Product::all()->each(function ($product) {

            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => 'products/default_image.webp',
                'is_primary' => true,
            ]);
        });
    }
}
