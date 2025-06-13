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
        Schema::create('nama_pegawai_ts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('ticket_id'); //foreign key ke tiket
                $table->string('nama_pegawai')->default('');
                $table->string('departemen')->default('');

                $table->timestamps();
        
                $table->foreign('ticket_id')->references('id')->on('ticketings')->onDelete('cascade');
    
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nama_pegawai_ts');
    }
};
