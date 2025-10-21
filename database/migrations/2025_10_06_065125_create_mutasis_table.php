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
        Schema::create('mutasis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket', 10)->unique();
            $table->string('nip', 20);
            $table->string('nama', 100);
            $table->string('no_hp', 15);
            $table->string('pangkat', 100);
            $table->string('jabatan', 100);
            $table->string('opd_asal', 100);
            $table->string('opd_tujuan', 100);
            $table->enum('jenis_mutasi', ['Mutasi Masuk', 'Mutasi Keluar', 'Mutasi Antar OPD']);
            $table->integer('status')->default(1);
            $table->date('tanggal_diterima')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasis');
    }
};
