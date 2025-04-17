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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_trans');
            $table->string('kode_trans')->unique();
            $table->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan');
            $table->dateTime('tanggal');
            $table->dateTime('batas_waktu');
            $table->enum('status', ['baru', 'diproses', 'selesai', 'diambil']);
            $table->enum('pembayaran', ['belum', 'lunas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
