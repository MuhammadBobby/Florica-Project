<?php

namespace Database\Factories;

use App\Enums\RoleUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),

            'email' => fake()->unique()->safeEmail(),

            'password' => Hash::make('password'),

            'phone' => fake()->numerify('08##########'),

            'avatar' => null,

            'role' => RoleUser::Customer,
        ];
    }
}
