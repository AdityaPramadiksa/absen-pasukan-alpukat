<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run()
{
    DB::table('outlets')->insert([
        'name'=>'Avocado Lovers',
        'latitude'=>-8.706887950123358,
        'longitude'=>115.26274367476128,
        'created_at'=>now(),
        'updated_at'=>now()
    ]);
}
}
