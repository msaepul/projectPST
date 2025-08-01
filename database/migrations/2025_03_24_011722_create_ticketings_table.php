<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 // database/migrations/xxxx_xx_xx_create_ticketings_table.php
public function up()
{
    Schema::create('ticketings', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('form_id')->nullable(); // relasi ke form jika ada
        $table->string('no_surat');
        $table->string('nama_pemohon');
        $table->string('assigned_By');
        $table->string('invoice');
        $table->date('issued');
        $table->double('nominal', 15, 2);
        $table->string('beban_biaya');
        $table->string('agent');
        $table->string('transport'); // contoh: "pesawat, kereta"
        $table->string('maskapai')->nullable();
        $table->string('kereta')->nullable();
        $table->string('bus')->nullable();
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
