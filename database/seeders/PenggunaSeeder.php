<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengguna::create([
            'id_pengguna' => (string) Str::uuid(),
            'nama_lengkap' => "Enggar Setiawan",
            'username' => 'ea',
            'password' => Hash::make("12345678")
        ]);
    }
}
