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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->enum('jenis_barang', ['bahan_baku', 'kemasan', 'produk_jadi']);
            $table->integer('stok')->default(0);
            $table->enum('satuan', ['kg', 'pcs']);
            $table->integer('batas_minimum')->default(0);
            $table->integer('batas_maksimum')->default(0);
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
    
};
