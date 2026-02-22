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
   Schema::create('retur_logs', function (Blueprint $table) {
    $table->id();

    $table->string('nama_item'); // ← LOGBOOK STYLE
    $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    $table->date('tanggal');

    $table->decimal('berat',8,2);

    $table->string('foto')->nullable();
    $table->text('alasan')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retur_logs');
    }
};
