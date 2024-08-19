<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Divisi;
use Illuminate\Support\Str;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'STAF',
            'ANGKAT - SEROK II',
            'ANGKAT - SORTIR',
            'BALL MILL BODY II',
            'BALL MILL GLASIR II',
            'MOUNTING',
            'KILN II',
            'E & M',
            'GUDANG BARANG JADI',
            'GLASIR II',
            'GUDANG SPAREPART',
            'GUDANG TRANSIT',
            'LABORAT',
            'UMUM',
            'LAIN - LAIN',
            'PRES II',
            'BODY',
            'ANGKAT - SORTIR II'
        ];

        foreach ($data as $nama_divisi) {
            Divisi::create([
                'id_divisi' => (string) Str::uuid(),
                'nama_divisi' => $nama_divisi
            ]);
        }
    }
}
