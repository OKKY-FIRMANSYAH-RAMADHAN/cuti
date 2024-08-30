<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SP;

class SPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $sp = SP::find($request->id_sp);
        $sp->tanggal = $request->tanggal;
        $update = $sp->save();
        if ($update) {
            session()->flash('success', 'Berhasil Mengubah SP Karyawan');
            return redirect()->route('karyawan.detail', ['id' => $sp->id_karyawan]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sp = SP::find($id);
        $delete = SP::destroy($id);
        if ($delete) {
            session()->flash('success', 'Berhasil Menghapus Data SP');
            return redirect()->route('karyawan.detail', ['id' => $sp->id_karyawan]);
        }
    }
}
