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
            $table->unsignedBigInteger('form_id'); // Foreign key ke tabel forms
            $table->string('no_surat')->unique();
            $table->string('nama_pemohon');
            $table->string('assigned_By');
            $table->string('hp')->default('');
            $table->string('agent')->default('');
            $table->string('issued')->default('');
            $table->string('transport')->default('');
            $table->string('maskapai')->default('');
            $table->string('invoice')->default('');
            $table->string('nominal')->default('');
            $table->string('beban_biaya')->default('');
            $table->string('kode_kendaraan')->default('');
            $table->string('rute')->default('');
            $table->string('tanggal_keberangkatan')->default('');
            $table->string('bulan_keberangkatan')->default('');
            $table->string('waktu_keberangkatan')->default('');


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
