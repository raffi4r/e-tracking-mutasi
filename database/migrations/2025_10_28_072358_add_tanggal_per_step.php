<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi (menambah kolom tanggal status).
     */
    public function up(): void
    {
        Schema::table('mutasis', function (Blueprint $table) {
            // Menambahkan kolom tanggal tiap step status
            $table->timestamp('tanggal_1')->nullable()->after('status');
            $table->timestamp('tanggal_2')->nullable()->after('tanggal_1');
            $table->timestamp('tanggal_3')->nullable()->after('tanggal_2');
            $table->timestamp('tanggal_4')->nullable()->after('tanggal_3');
            $table->timestamp('tanggal_5')->nullable()->after('tanggal_4');
            $table->timestamp('tanggal_6')->nullable()->after('tanggal_5');
            $table->timestamp('tanggal_7')->nullable()->after('tanggal_6');
        });
    }

    /**
     * Rollback migrasi (menghapus kolom tanggal jika dibatalkan).
     */
    public function down(): void
    {
        Schema::table('mutasis', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_1',
                'tanggal_2',
                'tanggal_3',
                'tanggal_4',
                'tanggal_5',
                'tanggal_6',
                'tanggal_7',
            ]);
        });
    }
};
