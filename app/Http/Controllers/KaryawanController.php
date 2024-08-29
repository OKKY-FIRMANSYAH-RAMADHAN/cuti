<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pengguna;
use App\Models\Bagian;
use App\Models\Divisi;
use App\Models\Cuti;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KaryawanImport;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $pengguna = Pengguna::where('id_pengguna', session()->get('id'))->first();

        if (session()->get('username') != 'ea') {
            $karyawan = Karyawan::where('id_divisi', $pengguna->id_divisi)->get();
            $cek = TRUE;
        }elseif (session()->get('username') == 'ea') {
            $karyawan = Karyawan::with('bagian')->with('divisi')->get();
            $cek = FALSE;
        }


        $data = [
            'title' => "List Data Karyawan",
            'karyawan' => $karyawan,
            'bagian' => Bagian::orderBy('nama_bagian', 'ASC')->get(),
            'divisi' => Divisi::orderBy('nama_divisi', 'ASC')->get(),
            'update' => Cuti::orderBy('updated_at', 'desc')->first(),
            'cek'   => $cek
        ];

        return view('karyawan', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|max:5000|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $import = Excel::import(new KaryawanImport, $file);

        if ($import) {
            session()->flash('success', 'Berhasil Mengimport Data Karyawan');
            return redirect()->route('karyawan');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $karyawan = new Karyawan();
        $karyawan->nama_karyawan = $request->nama_karyawan;
        $karyawan->id_bagian = $request->id_bagian;
        $karyawan->id_divisi = $request->id_divisi;
        $save = $karyawan->save();

        if ($save) {
            session()->flash('success', 'Berhasil Menambah Data Karyawan');
            return redirect()->route('karyawan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function cuti(Request $request)
    {
        $cuti = new Cuti();
        $cuti->id_karyawan = $request->id_karyawan;
        $cuti->tanggal = $request->tanggal;
        $cuti->keterangan = $request->keterangan;
        $save = $cuti->save();

        if ($save) {
            if ($request->keterangan === "C") {
                $karyawan = Karyawan::find($request->id_karyawan);
                $karyawan->sisa_cuti = $karyawan->sisa_cuti - 1;
                $karyawan->save();
            }
            session()->flash('success', 'Berhasil Menginput Cuti Karyawan');
            return redirect()->route('karyawan');
        }
    }

    public function setSisaCuti(Request $request) {
        $karyawan = Karyawan::find($request->id_karyawan);
        $karyawan->sisa_cuti = $request->sisa_cuti;
        $update = $karyawan->save();

        if ($update) {
            session()->flash('success', 'Berhasil Mengubah Sisa Cuti Karyawan');
            return redirect()->route('karyawan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail($id)
    {
        $karyawan = Karyawan::where('id_karyawan',$id)->get();
        $cuti = Cuti::where('id_karyawan', $karyawan[0]->id_karyawan)->orderBy('tanggal', 'desc')->get();

        $data = [
            'title'    => "Detail Karyawan ".$karyawan[0]->nama_karyawan,
            'karyawan' => $karyawan,
            'cuti'     => $cuti,
            'update' => Cuti::orderBy('updated_at', 'desc')->first()
        ];

        return view('detail', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $karyawan = Karyawan::find($request->id_karyawan);
        $karyawan->nama_karyawan = $request->nama_karyawan;
        $karyawan->id_bagian = $request->id_bagian;
        $karyawan->id_divisi = $request->id_divisi;
        $update = $karyawan->save();

        if ($update) {
            session()->flash('success', 'Berhasil Mengubah Data Karyawan');
            return redirect()->route('karyawan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete = Karyawan::destroy($id);
        if ($delete) {
            session()->flash('success', 'Berhasil Menghapus Data Karyawan');
            return redirect()->route('karyawan');
        }
    }
}
