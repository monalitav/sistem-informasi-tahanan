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
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi')->default('KEPOLISIAN RESOR MALANG');
            $table->string('alamat_instansi')->nullable();
            $table->string('telepon_instansi')->nullable();
            $table->string('nama_penanggung_jawab')->nullable();
            $table->string('pangkat_nrp_penanggung_jawab')->nullable();
            $table->string('jabatan_penanggung_jawab')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
