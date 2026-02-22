<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('shifts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


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
                'name' => 'middle',
                'code' => 'M',
                'start_time' => '11:00:00',
                'end_time' => '19:00:00',
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
