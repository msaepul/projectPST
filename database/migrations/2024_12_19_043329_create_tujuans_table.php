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
        Schema::create('tujuans', function (Blueprint $table) {
            $table->id();
            $table->string('tujuan_penugasan'); // Kolom tujuan penugasan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('tujuans');
    }
};
