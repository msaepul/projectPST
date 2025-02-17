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
    Schema::table('forms', function (Blueprint $table) {
        $table->string('submitted_by_bm')->nullable();
        $table->string('submitted_by_hrd')->nullable();
        $table->string('submitted_by_ho')->nullable();
        $table->string('submitted_by_cabang')->nullable();
    });
}

public function down()
{
    Schema::table('forms', function (Blueprint $table) {
        $table->dropColumn([
            'submitted_by_bm',
            'submitted_by_hrd',
            'submitted_by_ho',
            'submitted_by_cabang'
        ]);
    });
}
};