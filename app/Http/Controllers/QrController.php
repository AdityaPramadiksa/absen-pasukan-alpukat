<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QrController extends Controller
{
    public function generate()
    {
        $token = Str::random(32);

        DB::table('qr_tokens')->insert([
            'token' => $token,
            'expired_at' => Carbon::now()->addSeconds(30),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'token' => $token
        ]);
    }
}
