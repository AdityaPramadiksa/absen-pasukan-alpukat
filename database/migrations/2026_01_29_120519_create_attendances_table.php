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
    Schema::create('attendances', function (Blueprint $table) {

        $table->id();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('schedule_detail_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

        $table->foreignId('shift_id')
            ->constrained();

        $table->date('date');

        $table->time('checkin_time');

        $table->string('status');

        // GPS
        $table->decimal('latitude',10,7)->nullable();
        $table->decimal('longitude',10,7)->nullable();

        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
