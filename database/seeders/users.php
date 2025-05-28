<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'username' => 'admin123',
            'password' => Hash::make('123456'), // ganti dengan password yang aman
        ]);

        User::create([
            'name' => 'Member',
            'email' => 'member@member.com',
            'email_verified_at' => now(),
            'username' => 'member123',
            'password' => Hash::make('123456'),
        ]);
    }
}
