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
        Schema::create('survey_data', function (Blueprint $table) {
            $table->increments('id_survey');
            $table->string('nama_responden', 100);
            $table->string('no_telepon', 20);
            $table->string('kriteria', 100);
            $table->enum('hasil_survey', ['berminat', 'pikir-pikir', 'tidak berminat']);
            $table->unsignedInteger('id_pengguna');
            $table->timestamp('tanggal_input')->useCurrent();

            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('pengguna')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_data');
    }
};
