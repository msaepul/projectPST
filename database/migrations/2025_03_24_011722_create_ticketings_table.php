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
        Schema::create('ticketings', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->unique();
            $table->string('nama_pemohon');
            $table->string('assigned_By');
            $table->string('hp');
            $table->string('pegawai');
            $table->string('lampiran')->default('');
            $table->string('issued')->default('');
            $table->string('maskapai')->default('');
            $table->string('invoice')->default('');
            $table->string('transport')->default('');
            $table->string('beban_biaya')->default('');
            $table->string('keberangkatan')->default('');
            $table->string('nominal')->default('');
            $table->string('waktu')->default('');
            $table->string('rute')->default('');
            $table->string('rute_tujuan')->default('');
            $table->string('tiket')->default('');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticketings');
    }
};
