<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Karyawan extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $fillable = ['nama_karyawan', 'id_bagian', 'id_divisi', 'sisa_cuti'];

    public function bagian(): BelongsTo
    {
        return $this->belongsTo(Bagian::class, 'id_bagian', 'id_bagian')->select('id_bagian', 'nama_bagian');
    }

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'id_divisi', 'id_divisi')->select('id_divisi', 'nama_divisi');
    }

    public static function getCutiStatistics($limit = 10)
    {
        return self::select('karyawan.id_karyawan', 'karyawan.nama_karyawan', 'bagian.nama_bagian')
            ->selectRaw('COUNT(cuti.id_cuti) AS jumlah_cuti_total')
            ->selectRaw('COUNT(CASE WHEN cuti.keterangan IN ("S", "SD") THEN 1 END) AS sakit')
            ->selectRaw('COUNT(CASE WHEN cuti.keterangan = "I" THEN 1 END) AS ijin')
            ->selectRaw('COUNT(CASE WHEN cuti.keterangan = "A" THEN 1 END) AS alpa')
            ->selectRaw('COUNT(CASE WHEN cuti.keterangan = "DIS" THEN 1 END) AS dispen')
            ->join('cuti', 'karyawan.id_karyawan', '=', 'cuti.id_karyawan')
            ->leftJoin('bagian', 'karyawan.id_bagian', '=', 'bagian.id_bagian')
            ->groupBy('karyawan.id_karyawan', 'karyawan.nama_karyawan', 'bagian.nama_bagian')
            ->limit($limit)
            ->orderBy('jumlah_cuti_total', 'DESC');
    }
}
