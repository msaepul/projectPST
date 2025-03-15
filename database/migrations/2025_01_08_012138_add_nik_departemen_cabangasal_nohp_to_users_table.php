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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik')->nullable()->after('id');
            $table->string('departemen')->nullable()->after('nik');
            $table->string('cabang_asal')->nullable()->after('departemen');
            $table->string('no_hp')->nullable()->after('cabang_asal');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'departemen', 'cabang_asal', 'no_hp']);
        });
    }

};
