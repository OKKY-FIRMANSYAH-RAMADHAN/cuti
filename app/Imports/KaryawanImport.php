<?php

namespace App\Imports;

use App\Models\Karyawan;
use App\Models\Bagian;
use App\Models\Divisi;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class KaryawanImport implements ToCollection, WithHeadingRow
{
    public $data = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $bagian = Bagian::where('nama_bagian', '=', trim($row['bagian']))->first();
            $divisi = Divisi::where('nama_divisi', '=', trim($row['divisi']))->first();

            if (!$bagian) {
                $bagianOptions = Bagian::where('nama_bagian', 'LIKE', '%' . trim($row['bagian']) . '%')->get();
            }

            if (!$divisi) {
                $divisiOptions = Divisi::where('nama_divisi', 'LIKE', '%' . trim($row['divisi']) . '%')->get();
            }

            $existingKaryawan = Karyawan::where('nama_karyawan', trim($row['nama_karyawan']))
                ->where('id_bagian', $bagian ? $bagian->id_bagian : null)
                ->where('id_divisi', $divisi ? $divisi->id_divisi : null)
                ->first();

            if (!$existingKaryawan) {
                Karyawan::create([
                    'nama_karyawan' => $row['nama_karyawan'] ?? null,
                    'id_bagian' => $bagian ? $bagian->id_bagian : null,
                    'id_divisi' => $divisi ? $divisi->id_divisi : null,
                ]);
            }
        }
    }
}
