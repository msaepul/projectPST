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
            $table->string('no_surat')->default('');
            $table->string('nama_pemohon');
            $table->string('assigned_By');
            $table->string('invoice');
            $table->date('issued');
            $table->decimal('nominal', 15, 2);
            $table->string('beban_biaya');
            $table->string('agent');
            $table->string('kendaraan')->nullable();
            $table->string('maskapai');
            $table->string('class');
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
