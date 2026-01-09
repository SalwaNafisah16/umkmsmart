<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Fix: Kolom-kolom harus nullable untuk API registration
     */
    public function up(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->string('nama_usaha')->nullable()->change();
            $table->string('jenis_usaha')->nullable()->change();
            $table->string('alamat_usaha')->nullable()->change();
            $table->string('no_hp_usaha')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->string('nama_usaha')->nullable(false)->change();
            $table->string('jenis_usaha')->nullable(false)->change();
            $table->string('alamat_usaha')->nullable(false)->change();
            $table->string('no_hp_usaha')->nullable(false)->change();
        });
    }
};
