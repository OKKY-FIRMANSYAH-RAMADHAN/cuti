<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Cuti;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $pengguna = Pengguna::all();

        $data = [
            'title' => "List Data Pengguna",
            'update' => Cuti::orderBy('updated_at', 'desc')->first(),
            'divisi' => Divisi::orderBy('nama_divisi', 'ASC')->get(),
            'pengguna'  => Pengguna::with('divisi')->get()
        ];

        return view('pengguna', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pengguna = new Pengguna();
        $pengguna->nama_lengkap = $request->nama_lengkap;
        $pengguna->username     = trim($request->username);
        $pengguna->password     = Hash::make($request->password);
        $pengguna->id_divisi    = $request->id_divisi;
        $save = $pengguna->save();

        if ($save) {
            session()->flash('success', 'Berhasil Menambah Data Pengguna');
            return redirect()->route('pengguna');
        }
    }

    /**
     * Display the specified resource.
     */
    public function authlogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $pengguna = Pengguna::where('username', $request->username)->first();

        if ($pengguna && Hash::check($request->password, $pengguna->password)) {
            Session::put('id', $pengguna->id_pengguna);
            Session::put('nama', $pengguna->nama_lengkap);
            Session::put('username', $pengguna->username);
            Session::put('id_divisi', $pengguna->id_divisi);
            Session::put('logged_in', TRUE);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'Data Login Salah',
        ])->onlyInput('name')->with('error', 'Data login salah');;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengguna $pengguna)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $pengguna = Pengguna::find($request->id_pengguna);
        $pengguna->nama_lengkap = $request->nama_lengkap;
        $pengguna->username     = trim($request->username);
        if (!empty($request->password)) {
            $pengguna->password     = Hash::make($request->password);
        }
        $pengguna->id_divisi    = $request->id_divisi;
        $update = $pengguna->save();

        if ($update) {
            session()->flash('success', 'Berhasil Mengubah Data Pengguna');
            return redirect()->route('pengguna');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete = Pengguna::destroy($id);
        if ($delete) {
            session()->flash('success', 'Berhasil Menghapus Data Pengguna');
            return redirect()->route('pengguna');
        }
    }

    public function logout() {
        Session::forget('id');
        Session::forget('nama');
        Session::forget('username');
        Session::forget('id_divisi');
        Session::forget('logged_in');
        return redirect('/');
    }
}
