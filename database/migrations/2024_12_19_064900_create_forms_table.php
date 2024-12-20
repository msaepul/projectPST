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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id')->nullable(); 
            $table->string('cabang');
            $table->string('tujuan');
            $table->string('nama')->unique(); 
            $table->string('nik');
            $table->string('departemen');
            $table->string('lama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms'); // Menghapus tabel forms saat rollback
    }
};
