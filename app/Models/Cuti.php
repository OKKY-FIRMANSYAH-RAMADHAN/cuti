<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Cuti extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'cuti';
    protected $primaryKey = 'id_cuti';
    protected $fillable = ['id_karyawan', 'tanggal', 'keterangan'];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public static function getCountCutiAllTime($id_divisi = null){
        $cutiSummary = DB::table('cuti')
            ->join('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id_karyawan')
            ->select(
                DB::raw('YEAR(tanggal) as tahun'),
                DB::raw('SUM(CASE WHEN keterangan = "SD" THEN 1 ELSE 0 END) as total_SD'),
                DB::raw('SUM(CASE WHEN keterangan = "A" THEN 1 ELSE 0 END) as total_A'),
                DB::raw('SUM(CASE WHEN keterangan = "I" THEN 1 ELSE 0 END) as total_I'),
                DB::raw('SUM(CASE WHEN keterangan = "S" THEN 1 ELSE 0 END) as total_S'),
                DB::raw('SUM(CASE WHEN keterangan = "DIS" THEN 1 ELSE 0 END) as total_DIS')
            )
            ->when($id_divisi, function ($query) use ($id_divisi) {
                return $query->where('karyawan.id_divisi', $id_divisi);
            })
            ->groupBy(DB::raw('YEAR(tanggal)'))
            ->orderBy(DB::raw('YEAR(tanggal)'), 'asc')
            ->get();

        return $cutiSummary;
    }

    public static function getCountCutiByMonth($bulan, $tahun, $id_divisi = null){
        $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $cutiData = DB::table('cuti')
            ->join('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id_karyawan')
            ->select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw('SUM(CASE WHEN keterangan = "SD" THEN 1 ELSE 0 END) as total_SD'),
                DB::raw('SUM(CASE WHEN keterangan = "A" THEN 1 ELSE 0 END) as total_A'),
                DB::raw('SUM(CASE WHEN keterangan = "I" THEN 1 ELSE 0 END) as total_I'),
                DB::raw('SUM(CASE WHEN keterangan = "S" THEN 1 ELSE 0 END) as total_S'),
                DB::raw('SUM(CASE WHEN keterangan = "DIS" THEN 1 ELSE 0 END) as total_DIS')
            )
            ->when($id_divisi, function ($query) use ($id_divisi) {
                return $query->where('karyawan.id_divisi', $id_divisi);
            })
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy(DB::raw('DATE(tanggal)'), 'asc')
            ->get();

        $dates = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $cutiRecord = $cutiData->where('tanggal', $formattedDate)->first();
            $dates[$formattedDate] = (object)[
                'tanggal' => $formattedDate,
                'total_SD' => $cutiRecord->total_SD ?? 0,
                'total_A' => $cutiRecord->total_A ?? 0,
                'total_I' => $cutiRecord->total_I ?? 0,
                'total_S' => $cutiRecord->total_S ?? 0,
                'total_DIS' => $cutiRecord->total_DIS ?? 0
            ];
        }

        return collect($dates);
    }

    public static function getCountCutiByRange($startDate, $endDate, $id_divisi = null) {
        $months = [];
        $currentDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfMonth();

        while ($currentDate->lte($endDate)) {
            $bulanKey = $currentDate->format('Y-m');
            $months[$bulanKey] = (object)[
                'total_SD' => 0,
                'total_A' => 0,
                'total_I' => 0,
                'total_S' => 0,
                'total_DIS' => 0
            ];
            $currentDate->addMonth();
        }

        $cutiData = DB::table('cuti')
            ->join('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id_karyawan')
            ->select(
                DB::raw('YEAR(tanggal) as tahun'),
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('SUM(CASE WHEN keterangan = "SD" THEN 1 ELSE 0 END) as total_SD'),
                DB::raw('SUM(CASE WHEN keterangan = "A" THEN 1 ELSE 0 END) as total_A'),
                DB::raw('SUM(CASE WHEN keterangan = "I" THEN 1 ELSE 0 END) as total_I'),
                DB::raw('SUM(CASE WHEN keterangan = "S" THEN 1 ELSE 0 END) as total_S'),
                DB::raw('SUM(CASE WHEN keterangan = "DIS" THEN 1 ELSE 0 END) as total_DIS')
            )
            ->when($id_divisi, function ($query) use ($id_divisi) {
                return $query->where('karyawan.id_divisi', $id_divisi);
            })
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy(DB::raw('YEAR(tanggal)'), DB::raw('MONTH(tanggal)'))
            ->orderBy(DB::raw('YEAR(tanggal)'), 'asc')
            ->orderBy(DB::raw('MONTH(tanggal)'), 'asc')
            ->get();

        foreach ($cutiData as $data) {
            $bulanKey = $data->tahun . '-' . str_pad($data->bulan, 2, '0', STR_PAD_LEFT);
            if (isset($months[$bulanKey])) {
                $months[$bulanKey]->total_SD = $data->total_SD;
                $months[$bulanKey]->total_A = $data->total_A;
                $months[$bulanKey]->total_I = $data->total_I;
                $months[$bulanKey]->total_S = $data->total_S;
                $months[$bulanKey]->total_DIS = $data->total_DIS;
            }
        }

        return collect($months);
    }

    public static function getAvailableYears()
    {
        return DB::table('cuti')
            ->select(DB::raw('YEAR(tanggal) as tahun'))
            ->groupBy(DB::raw('YEAR(tanggal)'))
            ->orderBy(DB::raw('YEAR(tanggal)'), 'asc')
            ->pluck('tahun')
            ->toArray();
    }

}
