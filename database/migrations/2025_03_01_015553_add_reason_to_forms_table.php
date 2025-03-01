<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->text('reason_bm')->nullable();
            $table->text('reason_ho')->nullable();
            $table->text('reason_cabang')->nullable();
            $table->text('cancel_reason')->nullable();
        });
    }

    public function down()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn(['reason_bm', 'reason_ho', 'reason_cabang', 'cancel_reason']);
        });
    }
};
