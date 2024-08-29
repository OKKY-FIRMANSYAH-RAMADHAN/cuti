<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuti;
use App\Models\Divisi;
use App\Models\Karyawan;

class PengaturanController extends Controller
{
    public function index() {
        $data = [
            'title' => "Pengaturan",
            'divisi' => Divisi::orderBy('nama_divisi', "ASC")->get(),
            'update' => Cuti::orderBy('updated_at', 'desc')->first()
        ];

        return view('pengaturan', $data);
    }

    public function setCuti(Request $request) {
        foreach ($request->id_divisi as $key => $value) {
            Karyawan::where('id_divisi', $value)
            ->update(['sisa_cuti' => $request->sisa_cuti]);
        }

        return redirect(url('pengaturan'))->with('success','Berhasil Mengubah Pengaturan Sisa Cuti');
    }
}
