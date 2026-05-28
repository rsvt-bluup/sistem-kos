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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_bayar');

            $table->unsignedBigInteger('id_penyewa');
            $table->unsignedBigInteger('id_kamar');

            $table->date('tanggal_bayar');

            $table->integer('jumlah_bayar');

            // bukti pembayaran gambar
            $table->string('bukti_bayar');

            $table->string('bulan');

            $table->enum('status', ['Lunas', 'Belum Lunas']);

            $table->timestamps();

            $table->foreign('id_penyewa')
                  ->references('id_penyewa')
                  ->on('penyewas')
                  ->onDelete('cascade');

            $table->foreign('id_kamar')
                  ->references('id_kamar')
                  ->on('kamars')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};