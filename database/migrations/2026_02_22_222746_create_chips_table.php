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
        Schema::create('chips', function (Blueprint $table) {

            $table->id();

            // ================= MASTER DATA =================
            $table->string('nama_chips');

            // ================= STOK (KASIR MODE) =================
            $table->integer('qty_stock')->default(0);

            // OPTIONAL (kalau nanti mau harga)
            // $table->decimal('harga',10,0)->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chips');
    }
};
