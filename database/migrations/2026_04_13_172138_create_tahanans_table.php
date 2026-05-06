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
        Schema::create('tahanans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_registrasi')->unique();
            $table->string('nama');
            $table->string('nik')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('pasal')->nullable();
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar');
            $table->enum('status', ['aktif', 'keluar'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['status', 'tanggal_keluar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahanans');
    }
};
