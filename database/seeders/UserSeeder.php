<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::firstOrCreate(
            [
                'email' => 'owner@test.com',
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
            ]
        );

        $owner->assignRole('Owner');
    }
}
