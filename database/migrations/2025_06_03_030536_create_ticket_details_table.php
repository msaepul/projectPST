<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ticket_details', function (Blueprint $table) {
            $table->id();
        
            // Buat kolom ticket_id dulu
            $table->unsignedBigInteger('ticket_id');
        
            // Baru bikin foreign key
            $table->foreign('ticket_id')->references('id')->on('ticketings')->onDelete('cascade');
        
            $table->string('file_name')->nullable();
            $table->string('passenger_name');
            $table->string('flight_number');
            $table->string('flight_date');
            $table->string('departure_time');
            $table->string('departure_airport');
            $table->string('arrival_airport');
            $table->timestamps();
        });
        
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_details');
    }
};
