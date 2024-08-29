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
        return view('bagian', [
            'title' => 'List Data Bagian',
            'bagian' => Bagian::orderBy('nama_bagian', 'ASC')->get(),
            'update' => Cuti::orderBy('updated_at', 'desc')->first(),
        ]);
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
        $validate = $request->validate([
            'nama_bagian' => 'required',
        ]);

        $store = Bagian::create($validate);

        if ($store) {
            return redirect(url('bagian'))->with('success','Berhasil Menambah Data Bagian');
        }
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
        $validate = $request->validate([
            'nama_bagian' => 'required',
        ]);

        $bagian = Bagian::find($request->id_bagian);
        $update = $bagian->update($validate);

        if ($update) {
            return redirect(url('bagian'))->with('success','Berhasil Mengubah Data Bagian');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Bagian::destroy($id);
        if ($delete) {
            return redirect(url('bagian'))->with('success','Berhasil Menghapus Data Bagian');
        }
    }
}
