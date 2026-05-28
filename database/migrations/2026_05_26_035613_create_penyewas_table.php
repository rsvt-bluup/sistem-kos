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
        Schema::create('penyewas', function (Blueprint $table) {
            $table->id('id_penyewa');

            $table->string('nama');
            $table->string('no_hp');

            // gambar ktp
            $table->string('ktp');

            $table->unsignedBigInteger('id_kamar');

            $table->foreign('id_kamar')
                  ->references('id_kamar')
                  ->on('kamars')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewas');
    }
};