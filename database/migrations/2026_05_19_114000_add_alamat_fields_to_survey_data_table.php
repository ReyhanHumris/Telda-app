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
        Schema::table('survey_data', function (Blueprint $table) {
            $table->string('kecamatan', 100)->nullable();
            $table->text('alamat_detail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_data', function (Blueprint $table) {
            $table->dropColumn(['kecamatan', 'alamat_detail']);
        });
    }
};
