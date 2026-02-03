<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // staff / parttime / probation
            $table->string('employment_type')->default('staff');

            // fee gaji
            $table->integer('weekday_rate')->default(0);
            $table->integer('weekend_rate')->default(0);

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'employment_type',
                'weekday_rate',
                'weekend_rate'
            ]);

        });
    }
};
