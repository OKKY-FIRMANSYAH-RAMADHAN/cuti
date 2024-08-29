<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Cuti;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => "List Data Divisi",
            'divisi'  => Divisi::orderBy('nama_divisi', 'ASC')->get(),
            'update' => Cuti::orderBy('updated_at', 'desc')->first()
        ];

        return view('divisi', $data);
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
        $divisi = new Divisi();
        $divisi->nama_divisi = $request->nama_divisi;
        $save = $divisi->save();

        if ($save) {
            session()->flash('success', 'Berhasil Menambah Data Divisi');
            return redirect()->route('divisi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Divisi $divisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Divisi $divisi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $divisi = Divisi::find($request->id_divisi);
        $divisi->nama_divisi = $request->nama_divisi;
        $update = $divisi->save();

        if ($update) {
            session()->flash('success', 'Berhasil Mengubah Data Divisi');
            return redirect()->route('divisi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete = Divisi::destroy($id);
        if ($delete) {
            session()->flash('success', 'Berhasil Menghapus Data Divisi');
            return redirect()->route('divisi');
        }
    }
}
