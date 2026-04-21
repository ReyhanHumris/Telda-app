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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->increments('id_pengguna');
            $table->string('nama_lengkap', 100);
            $table->string('username', 50)->unique();
            // ERD: varchar(20) tapi untuk keamanan harus cukup panjang untuk hash bcrypt/argon
            $table->string('password');
            $table->enum('role', ['admin', 'officer'])->default('officer');
            $table->rememberToken();
            $table->timestamp('dibuat_pada')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
