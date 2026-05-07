<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::whereIn('email', [
            'admin@frigorlato.com',
            'despacho@frigorlato.com',
        ])->delete();

        User::updateOrCreate(
            ['email' => 'admin1@frigorlato.com'],
            [
                'name' => 'Admin 1',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin2@frigorlato.com'],
            [
                'name' => 'Admin 2',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin3@frigorlato.com'],
            [
                'name' => 'Admin 3',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'josuecaicedo949@gmail.com'],
            [
                'name' => 'Josue Caicedo',
                'password' => null,
                'role' => 'admin',
            ]
        );
    }
}
