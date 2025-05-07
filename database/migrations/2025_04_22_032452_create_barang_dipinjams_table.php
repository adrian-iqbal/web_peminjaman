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
        Schema::create('barang_dipinjams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->onDelete('cascade');
            $table->string('kode_barang');
            $table->foreignId('ruangan_id')
                ->constrained('ruangans')
                ->onDelete('cascade');
            $table->date('tanggal_pinjam');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_dipinjams');
    }
};
