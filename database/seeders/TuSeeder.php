<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'tu@sdmuhammadiyah.com'],
            [
                'name' => 'Admin Tata Usaha',
                'password' => Hash::make('password123'),
                'role' => 'tu'
            ]
        );
    }
}
