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
        Schema::create('nama_pegawais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id'); // Foreign key ke tabel forms
            $table->string('nama_pegawai');
            $table->string('departemen');
            $table->string('nik');
            $table->string('upload_file')->default('');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->string('acc_nm')->default('');
            $table->string('alasan')->default('');

            $table->timestamps();
    
            // Definisi foreign key
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nama_pegawais');
    }
};
