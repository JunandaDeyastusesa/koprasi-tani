<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class mitras extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mitras')->insert([
            [
                'id' => strtolower((string) Str::ulid()),
                'nama' => 'Mitra Tani A',
                'email' => 'mitra1@example.com',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Kebun Raya No. 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => strtolower((string) Str::ulid()),
                'nama' => 'Mitra Tani B',
                'email' => 'mitra2@example.com',
                'no_hp' => '082345678901',
                'alamat' => 'Jl. Sawah Luhur No. 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
