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
Schema::create('bantai_logs', function (Blueprint $table) {
    $table->id();

    $table->string('nama_item'); // ← LOGBOOK MODE
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    $table->date('tanggal');

    $table->decimal('before_weight',8,2);
    $table->decimal('waste_weight',8,2)->default(0);
    $table->decimal('retur_weight',8,2)->default(0);

    $table->decimal('after_weight',8,2);

    $table->string('foto_before')->nullable();
    $table->string('foto_after')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bantai_logs');
    }
};
