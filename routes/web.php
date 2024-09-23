<?php

use Illuminate\Support\Facades\Route;


Route::get('/login', [\App\Http\Controllers\PenggunaController::class, 'login'])->name('login')->middleware(\App\Http\Middleware\islogin::class);
Route::post('/login', [\App\Http\Controllers\PenggunaController::class, 'authlogin'])->name('auth.login')->middleware(\App\Http\Middleware\islogin::class);
Route::get('/logout', [\App\Http\Controllers\PenggunaController::class, 'logout'])->name('logout');


Route::middleware([\App\Http\Middleware\ceklogin::class])->group(function () {


    Route::middleware([\App\Http\Middleware\isnotadmin::class])->group(function () {
        Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

        // Bagian
        Route::get('/bagian', [\App\Http\Controllers\BagianController::class, 'index'])->name('bagian');
        Route::post('/bagian', [\App\Http\Controllers\BagianController::class, 'store'])->name('bagian.insert');
        Route::post('/bagian/update', [\App\Http\Controllers\BagianController::class, 'update'])->name('bagian.update');
        Route::get('/bagian/delete/{id}', [\App\Http\Controllers\BagianController::class, 'destroy'])->name('bagian.delete');

        // Divisi
        Route::get('/divisi', [\App\Http\Controllers\DivisiController::class, 'index'])->name('divisi');
        Route::post('/divisi', [\App\Http\Controllers\DivisiController::class, 'store'])->name('divisi.insert');
        Route::post('/divisi/update', [\App\Http\Controllers\DivisiController::class, 'update'])->name('divisi.update');
        Route::get('/divisi/delete/{id}', [\App\Http\Controllers\DivisiController::class, 'destroy'])->name('divisi.delete');

        // Riwayat Cuti
        Route::get('/riwayat', [\App\Http\Controllers\CutiController::class, 'index'])->name('riwayat');

        // Pengguna
        Route::get('/pengguna', [\App\Http\Controllers\PenggunaController::class, 'index'])->name('pengguna');
        Route::post('/pengguna', [\App\Http\Controllers\PenggunaController::class, 'store'])->name('pengguna.insert');
        Route::post('/pengguna/update', [\App\Http\Controllers\PenggunaController::class, 'update'])->name('pengguna.update');
        Route::get('/pengguna/delete/{id}', [\App\Http\Controllers\PenggunaController::class, 'destroy'])->name('pengguna.delete');

        // Karyawan
        Route::post('/karyawan', [\App\Http\Controllers\KaryawanController::class, 'store'])->name('karyawan.insert');
        Route::post('/karyawan/import', [\App\Http\Controllers\KaryawanController::class, 'import'])->name('karyawan.import');
        Route::post('/karyawan/cuti', [\App\Http\Controllers\KaryawanController::class, 'cuti'])->name('karyawan.cuti');
        Route::post('/karyawan/sp', [\App\Http\Controllers\KaryawanController::class, 'sp'])->name('karyawan.sp');
        Route::post('/karyawan/batchcuti', [\App\Http\Controllers\KaryawanController::class, 'batchcuti'])->name('karyawan.batchcuti');
        Route::post('/karyawan/set-sisa-cuti', [\App\Http\Controllers\KaryawanController::class, 'setSisaCuti'])->name('karyawan.setsisacuti');
        Route::post('/karyawan/update', [\App\Http\Controllers\KaryawanController::class, 'update'])->name('karyawan.update');
        Route::get('/karyawan/delete/{id}', [\App\Http\Controllers\KaryawanController::class, 'destroy'])->name('karyawan.delete');

        // Cuti
        Route::get('/cuti/delete/{id}', [\App\Http\Controllers\CutiController::class, 'destroy'])->name('cuti.delete');
        Route::post('/cuti/update', [\App\Http\Controllers\CutiController::class, 'update'])->name('cuti.update');

        // SP
        Route::get('/sp/delete/{id}', [\App\Http\Controllers\SPController::class, 'destroy'])->name('sp.delete');
        Route::post('/sp/update', [\App\Http\Controllers\SPController::class, 'update'])->name('sp.update');

        // Pengaturan
        Route::get('/pengaturan', [\App\Http\Controllers\PengaturanController::class, 'index'])->name('pengaturan');
        Route::post('/pengaturan/cuti', [\App\Http\Controllers\PengaturanController::class, 'setCuti'])->name('pengaturan.cuti');
    });

    // Karyawan
    Route::get('/karyawan', [\App\Http\Controllers\KaryawanController::class, 'index'])->name('karyawan');
    Route::get('/karyawan/detail/{id}', [\App\Http\Controllers\KaryawanController::class, 'detail'])->name('karyawan.detail');
});

