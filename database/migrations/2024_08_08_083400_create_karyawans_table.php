<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->uuid('id_karyawan')->primary();

            // Kolom foreign key didefinisikan sebagai nullable
            $table->uuid('id_bagian')->nullable();
            $table->uuid('id_divisi')->nullable();

            $table->string('nama_karyawan', 255);
            $table->integer('sisa_cuti')->default(12); // Default value should be an integer

            $table->timestamps();

            // Menambahkan foreign key constraints setelah kolom didefinisikan
            $table->foreign('id_bagian')->references('id_bagian')->on('bagian')->onDelete('set null');
            $table->foreign('id_divisi')->references('id_divisi')->on('divisi')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
