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
        // Schema::create('forms', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('tujuan_penugasan')->nullable(false);
        //     $table->string('cabang_tujuan')->nullable(false);
        //     $table->string('cabang_asal')->nullable(false);
        //     $table->string('no_surat')->nullable(false);
        //     $table->string('pembuat')->nullable(false);
        //     $table->string('berangkat')->nullable(false);
        //     $table->string('status_verifikasi')->nullable(false);
        //     $table->timestamps();
        // });

        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->unique();
            $table->string('nama_pemohon');
            $table->string('cabang_asal');
            $table->string('cabang_tujuan');
            $table->string('tujuan');
            $table->string('acc_bm')->default('');
            $table->string('acc_hrd')->default('');
            $table->string('acc_nm')->default('');
            $table->string('acc_ho')->default('');
            $table->string('acc_cabang')->default('');
            $table->date('tanggal_keberangkatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
