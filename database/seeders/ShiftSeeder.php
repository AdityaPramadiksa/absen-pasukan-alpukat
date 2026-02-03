<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('shifts')->insert([
            [
                'name' => 'pagi',
                'code' => 'O',
                'start_time' => '06:00:00',
                'end_time' => '14:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'siang',
                'code' => 'C',
                'start_time' => '13:45:00',
                'end_time' => '21:45:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
