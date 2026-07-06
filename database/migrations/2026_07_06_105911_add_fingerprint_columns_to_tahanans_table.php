<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tahanans', function (Blueprint $table) {
            $table->string('jempol_kanan')->nullable();
            $table->string('telunjuk_kanan')->nullable();
            $table->string('tengah_kanan')->nullable();
            $table->string('manis_kanan')->nullable();
            $table->string('kelingking_kanan')->nullable();

            $table->string('jempol_kiri')->nullable();
            $table->string('telunjuk_kiri')->nullable();
            $table->string('tengah_kiri')->nullable();
            $table->string('manis_kiri')->nullable();
            $table->string('kelingking_kiri')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tahanans', function (Blueprint $table) {
            $table->dropColumn([
                'jempol_kanan',
                'telunjuk_kanan',
                'tengah_kanan',
                'manis_kanan',
                'kelingking_kanan',
                'jempol_kiri',
                'telunjuk_kiri',
                'tengah_kiri',
                'manis_kiri',
                'kelingking_kiri',
            ]);
        });
    }
};