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
        Schema::create('topping_change_logs', function (Blueprint $table) {

            $table->id();

            // 🔥 TOPPING LAMA
            $table->string('nama_toping_lama');
            $table->decimal('berat_lama',8,2); // contoh: 50.00 gram

            // 🔥 TOPPING BARU
            $table->string('nama_toping_baru');
            $table->decimal('berat_baru',8,2);

            // USER STAFF YANG INPUT
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // TANGGAL CATAT
            $table->date('tanggal');

            // FOTO BUKTI (OPSIONAL)
            $table->string('foto')->nullable();

            // KETERANGAN OPSIONAL
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topping_change_logs');
    }
};
