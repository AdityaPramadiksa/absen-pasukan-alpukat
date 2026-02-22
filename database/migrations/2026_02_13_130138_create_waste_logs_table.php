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
    Schema::create('waste_logs', function (Blueprint $table) {
        $table->id();

        $table->string('nama_item');

        $table->foreignId('supplier_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->date('tanggal');

        // 🔥 TAMBAHAN BERAT (SIMPAN DALAM GRAM)
        $table->integer('berat')->nullable();

        $table->string('foto')->nullable();
        $table->text('keterangan')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_logs');
    }
};
