<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BagianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'ADMIN'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'ASRKII'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'ASTRII'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'BMB2'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'BMG2'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'BORONG'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'BTA'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'DIES'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'FLP'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'GBB'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'GDG'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'GLSTK2'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'GSP'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'GTST'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'HRM'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'KAYU'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'LAB'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'LOAD'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'M.STR'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'MAINT'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'MK'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'MOUNT'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'PAM'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'PEMB'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'PR'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'PRESII'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'PRINT'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'QC'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'SD2'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'SRK II'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'STR II'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'TK RK'],
            ['id_bagian' => (string) Str::uuid(), 'nama_bagian' => 'TK2'],
        ];

        DB::table('bagian')->insert($data);
    }
}
