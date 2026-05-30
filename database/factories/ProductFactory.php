<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Bouquet Mawar Premium',
            'Bouquet Wisuda Exclusive',
            'Bouquet Snack Special',
            'Bouquet Uang Elegant',
            'Gift Box Luxury',
        ]) . ' ' . fake()->unique()->numberBetween(1, 999);

        return [
            'category_id' => Category::inRandomOrder()->first()->id,

            'name' => $name,

            'slug' => Str::slug($name),

            'description' => fake()->paragraph(3),

            'price' => fake()->numberBetween(
                50000,
                300000
            ),

            'stock' => fake()->numberBetween(
                1,
                50
            ),

            'weight' => fake()->numberBetween(
                100,
                3000
            ),

            'is_active' => true,
        ];
    }
}
