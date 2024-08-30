<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuti;
use App\Models\Karyawan;
use App\Models\Divisi;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        Carbon::setLocale('id');
        $data = [
            'title' => 'Dashboard',
            'update' => Cuti::latest('updated_at')->first(),
            'divisi' => Divisi::orderBy('nama_divisi', "ASC")->get(),
        ];
        $totalKaryawan = Karyawan::count();

        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        $bulanMulai = $request->input('bulanmulai');
        $bulanAkhir = $request->input('bulanakhir');
        $divisi = $request->input('divisi');

        $bulanSekarang = Carbon::now()->month;
        $tahunSekarang = Carbon::now()->year;

        // Hitung Total Cuti by Keterangan
        $calculatetotalCuti = function($keterangan, $startDate, $endDate) {
            return count(Cuti::where('keterangan', $keterangan)->whereBetween('tanggal', [$startDate, $endDate])->get());
        };

        // Hitung Persentasi
        $calculatePercentage = function($totalC, $totalWorkingDays) use ($totalKaryawan) {
            return number_format(($totalC / ($totalKaryawan * $totalWorkingDays)) * 100, 1);
        };

        $calculatePercentage = function($totalC, $totalWorkingDays) use ($totalKaryawan) {
            $divisor = $totalKaryawan * $totalWorkingDays;
            if ($divisor == 0) {
                return 0;
            }

            return number_format(($totalC / $divisor) * 100, 1);
        };

        if ($divisi) {
            $find_divisi = Divisi::find($divisi);
            $data['selectDivisi'] = $find_divisi->nama_divisi;
        }else{
            $data['selectDivisi'] = "SEMUA DIVISI";
        }

        if ($bulan && $tahun) {
            $startDate              = Carbon::create($tahun, $bulan, 1);
            $endDate                = $startDate->copy()->endOfMonth();
            $totalWorkingDays       = floor($this->getWorkingDaysWithoutSundays($startDate, $endDate));

            $data['karyawan']       = Karyawan::getCutiStatistics(20, $divisi ?? NULL)->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->get();
            $data['selectValue']    = ($bulan == $bulanSekarang && $tahun == $tahunSekarang) ? 'Bulan Ini' : ($bulan == ($bulanSekarang - 1) ? "Bulan Kemarin" : Carbon::createFromFormat('!m', $bulan)->locale('id')->translatedFormat('F'). ' ' .$tahun);

            $keteranganArray = ['C', 'SD', 'DR', 'DIS', 'A', 'I', 'S'];
            foreach ($keteranganArray as $keterangan) {
                $data['total' . $keterangan] = $calculatetotalCuti($keterangan, $startDate, $endDate);
                $data['percent' . $keterangan] = $calculatePercentage($data['total' . $keterangan], $totalWorkingDays);
            }

            // Title Diagram Horizontal
            $data['tanggalBulanIni'] = range(1, $endDate->day);
            foreach ($keteranganArray as $keterangan) {
                $data['dataBar' . $keterangan] = Cuti::getCountCutiByMonth($bulan, $tahun, $divisi ?? NULL)
                    ->pluck('total_' . $keterangan)
                    ->map(fn($value) => (int) $value)
                    ->toArray();
            }

        } elseif ($tahun) {
            $startDate = Carbon::create($tahun, 1, 1)->startOfDay()->toDateString();
            $endDate = Carbon::create($tahun, 12, 1)->endOfMonth()->toDateString();

            $totalWorkingDays = floor($this->getWorkingDaysWithoutSundays(Carbon::create($tahun, 1, 1), Carbon::create($tahun, 12, 1)->endOfMonth()));
            $data['karyawan'] = Karyawan::getCutiStatistics(20, $divisi ?? NULL)->whereYear('tanggal', $tahun)->get();
            $data['selectValue'] = $tahunSekarang == $tahun ? 'Tahun Ini' : ($tahun == ($tahunSekarang - 1) ? 'Tahun Kemarin' : $tahun);

            $keteranganArray = ['C', 'SD', 'DR', 'DIS', 'A', 'I', 'S'];
            foreach ($keteranganArray as $keterangan) {
                $data['total' . $keterangan] = $calculatetotalCuti($keterangan, $startDate, $endDate);
                $data['percent' . $keterangan] = $calculatePercentage($data['total' . $keterangan], $totalWorkingDays);
            }

            // Title Diagram Horizontal
            $bulanIndo = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];

            $data['tanggalBulanIni'] = array_values(array_slice($bulanIndo, 1 - 1, 12 - 1 + 1));
            foreach ($keteranganArray as $keterangan) {
                $data['dataBar' . $keterangan] = Cuti::getCountCutiByRange($startDate, $endDate, $divisi ?? NULL)
                    ->pluck('total_' . $keterangan)
                    ->map(fn($value) => (int) $value)
                    ->toArray();
            }

        } elseif ($bulanMulai && $bulanAkhir) {
            $startDate = Carbon::create($tahunSekarang, $bulanMulai, 1)->startOfDay()->toDateString();
            $endDate = Carbon::create($tahunSekarang, $bulanAkhir, 1)->endOfMonth()->toDateString();
            $totalWorkingDays = floor($this->getWorkingDaysWithoutSundays(Carbon::create($tahunSekarang, $bulanMulai, 1), Carbon::create($tahunSekarang, $bulanAkhir, 1)->endOfMonth()));

            $data['karyawan'] = Karyawan::getCutiStatistics(20, $divisi ?? NULL)->whereBetween('tanggal', [$startDate, $endDate])->get();
            $data['selectValue'] = ($bulanAkhir - $bulanMulai + 1) . " Bulan Terakhir";

            $keteranganArray = ['C', 'SD', 'DR', 'DIS', 'A', 'I', 'S'];
            foreach ($keteranganArray as $keterangan) {
                $data['total' . $keterangan] = $calculatetotalCuti($keterangan, $startDate, $endDate);
                $data['percent' . $keterangan] = $calculatePercentage($data['total' . $keterangan], $totalWorkingDays);
            }

            // Title Diagram Horizontal
            $bulanIndo = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
            $data['tanggalBulanIni'] = array_values(array_slice($bulanIndo, $bulanMulai - 1, $bulanAkhir - $bulanMulai + 1));
            foreach ($keteranganArray as $keterangan) {
                $data['dataBar' . $keterangan] = Cuti::getCountCutiByRange($startDate, $endDate, $divisi ?? NULL)
                    ->pluck('total_' . $keterangan)
                    ->map(fn($value) => (int) $value)
                    ->toArray();
            }

        }else {
            $startDate = Carbon::create((Cuti::getAvailableYears()[0] ?? $tahunSekarang), 1, 1);
            $endDate = Carbon::create($tahunSekarang, 12, 1)->endOfMonth();
            $totalWorkingDays = floor($this->getWorkingDaysWithoutSundays($startDate, $endDate));

            $data['karyawan'] = Karyawan::getCutiStatistics(20, $divisi ?? NULL)->get();
            $data['selectValue'] = "Sepanjang Masa";

            // Value Card
            $keteranganArray = ['C', 'SD', 'DR', 'DIS', 'A', 'I', 'S'];
            foreach ($keteranganArray as $keterangan) {
                $data['total' . $keterangan] = $calculatetotalCuti($keterangan, $startDate, $endDate);
                $data['percent' . $keterangan] = $calculatePercentage($data['total' . $keterangan], $totalWorkingDays);
            }

            // Title Diagram Horizontal
            $data['tanggalBulanIni'] = Cuti::getAvailableYears();
            foreach ($keteranganArray as $keterangan) {
                $data['dataBar' . $keterangan] = Cuti::getCountCutiAllTime($divisi ?? NULL)
                    ->sortBy('tahun')
                    ->pluck('total_' . $keterangan)
                    ->map(fn($value) => (int) $value)
                    ->toArray();
            }
        }

        return view('dashboard', $data);
    }

    private function getWorkingDaysWithoutSundays(Carbon $startDate, Carbon $endDate)
    {
        $totalDays = $startDate->diffInDays($endDate) + 1;
        $sundays = 0;

        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            if ($date->isSunday()) {
                $sundays++;
            }
        }

        return $totalDays - $sundays;
    }

    private function getAllDatesInMonth($year, $month) {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $dates = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dates[] = $date->format('d M Y');
        }
        return $dates;
    }
}
