<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chip_sales', function (Blueprint $table) {

            $table->id();

            // ================= RELATION =================
            $table->foreignId('chip_id')->constrained('chips')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // ================= TRANSAKSI =================
            $table->integer('qty');

            $table->enum('metode_bayar',[
                'cash',
                'debit',
                'kredit',
                'qris'
            ]);

            // pakai datetime biar bisa laporan jam
            $table->dateTime('tanggal');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chip_sales');
    }
};
