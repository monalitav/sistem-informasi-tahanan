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
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahanan_id')->constrained('tahanans')->cascadeOnDelete();
            $table->enum('jenis', ['keluar_hari_ini', 'keluar_7_hari']);
            $table->date('tanggal_target');
            $table->text('pesan');
            $table->timestamp('terbaca_at')->nullable();
            $table->timestamps();

            $table->unique(['tahanan_id', 'jenis', 'tanggal_target']);
            $table->index(['jenis', 'tanggal_target']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
