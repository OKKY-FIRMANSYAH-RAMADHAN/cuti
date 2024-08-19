<?php

use Illuminate\Support\Facades\Route;


Route::get('/login', [\App\Http\Controllers\PenggunaController::class, 'login'])->name('login')->middleware(\App\Http\Middleware\islogin::class);
Route::post('/login', [\App\Http\Controllers\PenggunaController::class, 'authlogin'])->name('auth.login')->middleware(\App\Http\Middleware\islogin::class);
Route::get('/logout', [\App\Http\Controllers\PenggunaController::class, 'logout'])->name('logout');


Route::middleware([\App\Http\Middleware\ceklogin::class])->group(function () {

    // Bagian
    Route::middleware([\App\Http\Middleware\isnotadmin::class])->group(function () {
        Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/bagian', [\App\Http\Controllers\BagianController::class, 'index'])->name('bagian');
        Route::post('/bagian', [\App\Http\Controllers\BagianController::class, 'store'])->name('bagian.insert');
        Route::post('/bagian/update', [\App\Http\Controllers\BagianController::class, 'update'])->name('bagian.update');
        Route::get('/bagian/delete/{id}', [\App\Http\Controllers\BagianController::class, 'destroy'])->name('bagian.delete');

        // Divisi
        Route::get('/divisi', [\App\Http\Controllers\DivisiController::class, 'index'])->name('divisi');
        Route::post('/divisi', [\App\Http\Controllers\DivisiController::class, 'store'])->name('divisi.insert');
        Route::post('/divisi/update', [\App\Http\Controllers\DivisiController::class, 'update'])->name('divisi.update');
        Route::get('/divisi/delete/{id}', [\App\Http\Controllers\DivisiController::class, 'destroy'])->name('divisi.delete');

        Route::get('/riwayat', [\App\Http\Controllers\CutiController::class, 'index'])->name('riwayat');

        Route::get('/pengguna', [\App\Http\Controllers\PenggunaController::class, 'index'])->name('pengguna');
        Route::post('/pengguna', [\App\Http\Controllers\PenggunaController::class, 'store'])->name('pengguna.insert');
        Route::post('/pengguna/update', [\App\Http\Controllers\PenggunaController::class, 'update'])->name('pengguna.update');
        Route::get('/pengguna/delete/{id}', [\App\Http\Controllers\PenggunaController::class, 'destroy'])->name('pengguna.delete');

        Route::post('/karyawan', [\App\Http\Controllers\KaryawanController::class, 'store'])->name('karyawan.insert');
        Route::post('/karyawan/import', [\App\Http\Controllers\KaryawanController::class, 'import'])->name('karyawan.import');
        Route::post('/karyawan/cuti', [\App\Http\Controllers\KaryawanController::class, 'cuti'])->name('karyawan.cuti');
        Route::post('/karyawan/update', [\App\Http\Controllers\KaryawanController::class, 'update'])->name('karyawan.update');
        Route::get('/karyawan/delete/{id}', [\App\Http\Controllers\KaryawanController::class, 'destroy'])->name('karyawan.delete');
    });

    // Karyawan
    Route::get('/karyawan', [\App\Http\Controllers\KaryawanController::class, 'index'])->name('karyawan');
    Route::get('/karyawan/detail/{id}', [\App\Http\Controllers\KaryawanController::class, 'detail'])->name('karyawan.detail');
});

