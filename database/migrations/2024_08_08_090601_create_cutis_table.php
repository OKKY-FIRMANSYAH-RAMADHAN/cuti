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
        Schema::create('cuti', function (Blueprint $table) {
            $table->uuid('id_cuti')->primary();
            $table->foreignUuid('id_karyawan')->references('id_karyawan')->on('karyawan')->onDelete('cascade');
            $table->date('tanggal',255);
            $table->enum('keterangan', ['C','SD', 'S', 'I', 'A', 'DR', 'DIS'])->default('C');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};
