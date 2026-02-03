<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{

    private $radius = 100; // meter

    // hitung jarak GPS (meter)
    private function distance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }

    public function store(Request $request)
    {
        $userId = auth()->id();
        $today = now()->format('Y-m-d');
        $now = now();

        // ================= GPS =================

        $lat = $request->latitude;
        $lng = $request->longitude;

        if(!$lat || !$lng){
            return response()->json([
                'message'=>'Lokasi tidak terdeteksi'
            ]);
        }

        // ================= AMBIL LOKASI OUTLET DARI DB =================

        $outlet = DB::table('outlets')->first();

        if(!$outlet){
            return response()->json([
                'message'=>'Lokasi outlet belum diset'
            ]);
        }

        $distance = $this->distance(
            $lat,
            $lng,
            $outlet->latitude,
            $outlet->longitude
        );

        // if($distance > $this->radius){
        //     return response()->json([
        //         'message'=>'Kamu berada di luar area outlet'
        //     ]);
        // }

        // ================= LOGIC LAMA (AMAN) =================

        // ambil jadwal hari ini
        $schedule = DB::table('schedule_details')
            ->join('shifts','shifts.id','=','schedule_details.shift_id')
            ->where('schedule_details.user_id',$userId)
            ->where('schedule_details.date',$today)
            ->select(
                'schedule_details.shift_id',
                'shifts.start_time'
            )
            ->first();

        if(!$schedule){
            return response()->json([
                'message'=>'Hari ini kamu OFF'
            ]);
        }

        // cegah double absen
        $exists = DB::table('attendances')
            ->where('user_id',$userId)
            ->where('date',$today)
            ->exists();

        if($exists){
            return response()->json([
                'message'=>'Kamu sudah absen hari ini'
            ]);
        }

        // hitung telat
        $shiftStart = now()->setTimeFromTimeString($schedule->start_time);
        $status = $now->gt($shiftStart) ? 'telat' : 'ontime';

        DB::table('attendances')->insert([
            'user_id'=>$userId,
            'shift_id'=>$schedule->shift_id,
            'date'=>$today,
            'checkin_time'=>$now->format('H:i:s'),
            'status'=>$status,
            'latitude'=>$lat,
            'longitude'=>$lng,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);

        return response()->json([
            'message'=>'Absensi berhasil ('.$status.')'
        ]);
    }
}
