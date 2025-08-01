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
            $table->unsignedBigInteger('ticket_id');
            $table->string('file_name');
            $table->string('passenger_name');
            $table->string('flight_number')->nullable();
            $table->string('flight_date')->nullable();
            $table->string('departure_time')->nullable();
            $table->string('departure_airport')->nullable();
            $table->string('arrival_airport')->nullable();
            $table->timestamps();
    
            $table->foreign('ticket_id')->references('id')->on('ticketings')->onDelete('cascade');
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
