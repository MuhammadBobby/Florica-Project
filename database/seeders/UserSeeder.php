<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RoleUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'full_name' => 'Administrator',
            'email' => 'admin@laisa.com',
            'password' => Hash::make('password'),
            'phone' => '081111111111',
            'role' => RoleUser::Admin,
        ]);

        User::factory()
            ->count(20)
            ->create();
    }
}
