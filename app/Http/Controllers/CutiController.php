<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => "Riwayat Tidak Masuk",
            'riwayat' => Cuti::with('karyawan.bagian', 'karyawan.divisi')->orderBy('tanggal', 'desc')->get(),
            'update' => Cuti::orderBy('updated_at', 'desc')->first()
        ];

        return view('riwayat', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuti $cuti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuti $cuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $cuti = Cuti::find($request->id_cuti);
        if ($cuti->keterangan != "C") {
            if ($request->keterangan === "C") {
                $karyawan = Karyawan::find($cuti->id_karyawan);
                $karyawan->sisa_cuti = $karyawan->sisa_cuti - 1;
                $karyawan->save();
            }
        }elseif($cuti->keterangan === "C"){
            if ($request->keterangan != "C") {
                $karyawan = Karyawan::find($cuti->id_karyawan);
                $karyawan->sisa_cuti = $karyawan->sisa_cuti + 1;
                $karyawan->save();
            }
        }

        $cuti->tanggal = $request->tanggal;
        $cuti->keterangan = $request->keterangan;
        $update = $cuti->save();
        if ($update) {
            session()->flash('success', 'Berhasil Mengubah Cuti Karyawan');
            return redirect()->route('karyawan.detail', ['id' => $cuti->id_karyawan]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cuti = Cuti::find($id);
        if ($cuti->keterangan === "C") {
            $karyawan = Karyawan::find($cuti->id_karyawan);
            $karyawan->sisa_cuti = $karyawan->sisa_cuti + 1;
            $karyawan->save();
        }
        $delete = Cuti::destroy($id);
        if ($delete) {
            session()->flash('success', 'Berhasil Menghapus Data Cuti');
            return redirect()->route('karyawan.detail', ['id' => $cuti->id_karyawan]);
        }
    }
}
