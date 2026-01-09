<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            // rename kolom lama
            $table->renameColumn('name', 'nama_produk');
            $table->renameColumn('price', 'harga');
            $table->renameColumn('description', 'deskripsi');

            // kolom tambahan
            $table->integer('stok')->default(0)->after('harga');
            $table->string('gambar')->nullable()->after('stok');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('gambar');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            // balikin nama kolom
            $table->renameColumn('nama_produk', 'name');
            $table->renameColumn('harga', 'price');
            $table->renameColumn('deskripsi', 'description');

            // hapus kolom tambahan
            $table->dropColumn(['stok', 'gambar', 'status']);
        });
    }
};
