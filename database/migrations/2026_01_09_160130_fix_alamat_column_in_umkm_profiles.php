<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Fix: Kolom 'alamat' harus nullable karena tidak selalu diisi
     */
    public function up(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            // Ubah kolom alamat menjadi nullable
            $table->string('alamat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->string('alamat')->nullable(false)->change();
        });
    }
};
