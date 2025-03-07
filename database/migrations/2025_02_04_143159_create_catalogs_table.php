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
        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_katalog');
            $table->text('deskripsi');
            $table->integer('stok');
            $table->enum('tipe_bahan', [
                'Cotton Combed', 'Cotton Slub', 'Polyester', 
                'Tri-blend', 'Rayon', 'Spandex', 'Teteron Cotton (TC)', 
                'Viscose', 'Hyget', 'Baby Terry', 'Lacoste', 
                'CVC (Chief Value Cotton)', 'Drill', 'Fleece'
            ]);
            $table->enum('jenis_katalog', ['baju', 'celana anak', 'baju keluarga']);
            $table->integer('harga');
            $table->string('gambar');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogs');
    }
};
