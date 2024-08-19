<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use App\Models\Cuti;
use Illuminate\Http\Request;

class BagianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => "List Data Bagian",
            'bagian'  => Bagian::all(),
            'update' => Cuti::orderBy('updated_at', 'desc')->first()
        ];

        return view('bagian', $data);
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
        $bagian = new Bagian();
        $bagian->nama_bagian = $request->nama_bagian;
        $save = $bagian->save();

        if ($save) {
            session()->flash('success', 'Berhasil Menambah Data Bagian');
            return redirect()->route('bagian');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bagian $bagian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bagian $bagian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $bagian = Bagian::find($request->id_bagian);
        $bagian->nama_bagian = $request->nama_bagian;
        $update = $bagian->save();

        if ($update) {
            session()->flash('success', 'Berhasil Mengubah Data Bagian');
            return redirect()->route('bagian');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete = Bagian::destroy($id);
        if ($delete) {
            session()->flash('success', 'Berhasil Menghapus Data Bagian');
            return redirect()->route('bagian');
        }
    }
}
