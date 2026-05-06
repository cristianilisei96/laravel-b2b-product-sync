<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $customerRole = Role::where('slug', 'customer')->first();

        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Demo Admin',
                'password' => '12345678',
                'role_id' => $adminRole?->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'Demo Customer',
                'password' => '12345678',
                'role_id' => $customerRole?->id,
            ]
        );
    }
}
