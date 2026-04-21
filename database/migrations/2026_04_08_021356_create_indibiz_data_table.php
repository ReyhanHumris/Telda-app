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
        Schema::create('indibiz_data', function (Blueprint $table) {
            $table->increments('id_indibiz');
            $table->string('nama_perusahaan', 100);
            $table->text('alamat_perusahaan');
            $table->string('jenis_layanan', 50);
            $table->enum('status_langganan', ['aktif', 'nonaktif'])->default('aktif');
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
        Schema::dropIfExists('indibiz_data');
    }
};
