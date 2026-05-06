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
        Schema::table('tahanans', function (Blueprint $table) {
            $table->string('nama_alias')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat_terakhir')->nullable();
            $table->string('nama_ayah')->nullable();

            $table->string('jenis_kejahatan')->nullable();
            $table->string('pasal_yang_dilanggar')->nullable();
            $table->text('modus_operandi')->nullable();
            $table->string('nomor_sprint')->nullable();
            $table->date('tanggal_sprint')->nullable();

            $table->string('foto_sidik_jari')->nullable();
            $table->string('foto_tampak_depan')->nullable();
            $table->string('foto_samping_kanan')->nullable();
            $table->string('foto_samping_kiri')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tahanans', function (Blueprint $table) {
            $table->dropColumn([
                'nama_alias',
                'pekerjaan',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat_terakhir',
                'nama_ayah',
                'jenis_kejahatan',
                'pasal_yang_dilanggar',
                'modus_operandi',
                'nomor_sprint',
                'tanggal_sprint',
                'foto_sidik_jari',
                'foto_tampak_depan',
                'foto_samping_kanan',
                'foto_samping_kiri',
            ]);
        });
    }
};
