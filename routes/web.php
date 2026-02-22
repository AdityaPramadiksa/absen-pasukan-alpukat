<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exports\PayrollExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Inventory\WasteController;
use App\Http\Controllers\Inventory\StockController;
use App\Http\Controllers\Inventory\BantaiController;
use App\Http\Controllers\Inventory\BarangMasukController;
use App\Http\Controllers\Inventory\ReturController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Inventory\ChipController;
use App\Http\Controllers\Inventory\ChipSaleController;
use App\Http\Controllers\Inventory\ToppingChangeController;



/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => redirect('/login'));

/*
|--------------------------------------------------------------------------
| OUTLET QR DISPLAY (PUBLIC)
|--------------------------------------------------------------------------
*/

Route::get('/outlet-display', function () {
    return view('admin.outlet');
})->name('outlet.display');

/*
|--------------------------------------------------------------------------
| ROLE REDIRECT AFTER LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/redirect', function () {

    return auth()->user()->role === 'admin'
        ? redirect('/admin')
        : redirect('/staff');

});

/*
|--------------------------------------------------------------------------
| QR TOKEN PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/qr-public', [QrController::class, 'generate']);

/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->group(function () {

       Route::get('/', function () {

            $today = now()->format('Y-m-d');

            // staff dijadwalkan hari ini
            $scheduled = DB::table('schedule_details')
                ->where('date',$today)
                ->pluck('user_id');

            $totalScheduled = $scheduled->count();

            // hadir hari ini
            $hadir = DB::table('attendances')
                ->where('date',$today)
                ->count();

            // telat hari ini
            $telat = DB::table('attendances')
                ->where('date',$today)
                ->where('status','telat')
                ->count();

            // sudah absen
            $sudahAbsen = DB::table('attendances')
                ->where('date',$today)
                ->pluck('user_id');

            // belum absen (REAL)
            $belumAbsen = $scheduled->diff($sudahAbsen)->count();

            // recent attendance
            $recent = DB::table('attendances')
                ->join('users','users.id','=','attendances.user_id')
                ->join('shifts','shifts.id','=','attendances.shift_id')
                ->where('attendances.date',$today)
                ->select(
                    'users.name',
                    'attendances.checkin_time',
                    'attendances.status',
                    'shifts.code'
                )
                ->orderByDesc('attendances.checkin_time')
                ->limit(5)
                ->get();

            return view('admin.dashboard',compact(
                'totalScheduled',
                'hadir',
                'telat',
                'belumAbsen',
                'recent'
            ));
        });

        // export
        Route::get('/payroll-export', function(Request $request){

            $from = $request->from;
            $to   = $request->to;

            return Excel::download(
                new PayrollExport($from,$to),
                'payroll_'.$from.'_to_'.$to.'.xlsx'
            );

        })->name('admin.payroll.export');

        /*
|--------------------------------------------------------------------------
| HISTORY INVENTORY ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/history',[HistoryController::class,'index']);

/*
|--------------------------------------------------------------------------
| SUPPLIER ADMIN
|--------------------------------------------------------------------------
*/

Route::get('/suppliers',[SupplierController::class,'index']);
Route::post('/suppliers',[SupplierController::class,'store']);
Route::delete('/suppliers/{id}',[SupplierController::class,'destroy']);


        /*
        | Attendance (Admin)
        */
        Route::get('/attendance', function (Request $request) {

            $from = $request->from ?? now()->subDays(7)->format('Y-m-d');
            $to   = $request->to ?? now()->format('Y-m-d');

            $data = DB::table('attendances')
                ->join('users','users.id','=','attendances.user_id')
                ->join('shifts','shifts.id','=','attendances.shift_id')
                ->whereBetween('attendances.date', [$from,$to])
                ->select(
                    'users.name',
                    'attendances.date',
                    'attendances.checkin_time',
                    'shifts.code as shift',
                    'attendances.status'
                )
                ->orderByDesc('attendances.date')
                ->get();

            return view('admin.attendance', compact(
                'data',
                'from',
                'to'
            ));
        });

        /*
        | STAFF MANAGEMENT
        */
        Route::get('/staff', function () {

            $staff = DB::table('users')
                ->where('role','staff')
                ->get();

            return view('admin.staff', compact('staff'));
        });

        Route::post('/staff', function (Request $request) {

           DB::table('users')->insert([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt('staff123'),
                'role'=>'staff',
                'employment_type'=>$request->employment_type,
                'weekday_rate'=>$request->weekday_rate,
                'weekend_rate'=>$request->weekend_rate,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);

            return back()->with('success','Staff berhasil ditambahkan');
        });

        Route::delete('/staff/{id}', function ($id) {

            DB::table('users')
                ->where('id',$id)
                ->delete();

            return back()->with('success','Staff berhasil dihapus');
        });

        Route::post('/staff/reset-password/{id}', function ($id) {

            DB::table('users')
                ->where('id', $id)
                ->update([
                    'password'   => bcrypt('staff123'),
                    'updated_at'=> now()
                ]);

            return back()->with('success','Password staff berhasil direset ke staff123');
        });

        Route::get('/staff/{id}/edit', function ($id) {

            $staff = DB::table('users')->where('id',$id)->first();

            return view('admin.staff-edit', compact('staff'));
        });

        Route::post('/staff/{id}/update', function (Request $request, $id) {

            DB::table('users')
                ->where('id',$id)
                ->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'employment_type'=>$request->employment_type,
                    'weekday_rate'=>$request->weekday_rate,
                    'weekend_rate'=>$request->weekend_rate,
                    'updated_at'=>now()
                ]);

            return redirect('/admin/staff')->with('success','Staff berhasil diupdate');
        });



        /*
        | SCHEDULE EDIT
        */
        Route::get('/schedule', function (Request $request) {

            $staff = DB::table('users')->where('role','staff')->get();
            $shifts = DB::table('shifts')->get();

            $weekStart = $request->week_start ?? now()->startOfWeek()->format('Y-m-d');

            return view('admin.schedule', compact('staff','shifts','weekStart'));
        });

        Route::post('/schedule-grid', function (Request $request) {

            // kalau tidak ada input sama sekali
            if (!$request->has('schedule')) {
                return back()->with('error','Tidak ada jadwal yang dipilih');
            }

            $saved = false;

            foreach ($request->schedule as $user => $days) {
                foreach ($days as $date => $shift) {

                    if ($shift != 'off') {

                        DB::table('schedule_details')->updateOrInsert(
                            [
                                'user_id' => $user,
                                'date'    => $date
                            ],
                            [
                                'shift_id'   => $shift,
                                'created_at'=> now(),
                                'updated_at'=> now()
                            ]
                        );

                        $saved = true;
                    }
                }
            }

            if (!$saved) {
                return back()->with('error','Tidak ada jadwal yang disimpan');
            }

            return back()->with('success','Jadwal berhasil disimpan');
        });

        // PAYROLL ADMIN (SEMUA STAFF + ABSEN + CUTI + LEMBUR)
        Route::get('/payroll', function(Request $request){

            $from = $request->from ?? now()->subMonth()->day(25)->format('Y-m-d');
            $to   = $request->to ?? now()->day(25)->format('Y-m-d');

            // semua staff
            $users = DB::table('users')
                ->where('role','staff')
                ->get();

            // overtime rate
            $overtimeRate = DB::table('settings')
                ->where('key','overtime_rate')
                ->value('value') ?? 0;

            // attendance
            $attendance = DB::table('attendances')
                ->whereBetween('date',[$from,$to])
                ->get()
                ->groupBy('user_id');

            // cuti approved
            $leaves = DB::table('leaves')
                ->where('status','approved')
                ->whereBetween('date',[$from,$to])
                ->get()
                ->groupBy('user_id');

            // overtime
            $overtimes = DB::table('overtimes')
                ->select('user_id', DB::raw('SUM(hours) as total'))
                ->whereBetween('date',[$from,$to])
                ->groupBy('user_id')
                ->pluck('total','user_id');

            $recap = [];

            foreach($users as $u){

                $weekday = 0;
                $weekend = 0;
                $cuti = isset($leaves[$u->id]) ? $leaves[$u->id]->count() : 0;

                if(isset($attendance[$u->id])){
                    foreach($attendance[$u->id] as $a){
                        $day = date('w',strtotime($a->date));
                        if($day==0 || $day==6) $weekend++;
                        else $weekday++;
                    }
                }

                $overtimeHours = $overtimes[$u->id] ?? 0;

                $gajiWeekday = ($weekday + $cuti) * $u->weekday_rate;
                $gajiWeekend = $weekend * $u->weekend_rate;
                $gajiLembur  = $overtimeHours * $overtimeRate;

                $recap[] = [
                    'name'=>$u->name,
                    'weekday'=>$weekday,
                    'weekend'=>$weekend,
                    'cuti'=>$cuti,
                    'weekday_rate'=>$u->weekday_rate,
                    'weekend_rate'=>$u->weekend_rate,
                    'overtime_hours'=>$overtimeHours,
                    'total'=>$gajiWeekday + $gajiWeekend + $gajiLembur
                ];
            }

            return view('admin.payroll',compact(
                'recap',
                'from',
                'to',
                'overtimeRate'
            ));

        });

        /*
        | OVERTIME ADMIN
        */
       Route::get('/overtime', function(){

            $rate = DB::table('settings')
                ->where('key','overtime_rate')
                ->value('value') ?? 0;

            // HISTORY
            $data = DB::table('overtimes')
                ->join('users','users.id','=','overtimes.user_id')
                ->select(
                    'users.name',
                    'overtimes.date',
                    'overtimes.hours'
                )
                ->orderByDesc('overtimes.date')
                ->get();

            // SUMMARY + TOTAL RUPIAH
            $summary = DB::table('overtimes')
                ->join('users','users.id','=','overtimes.user_id')
                ->select(
                    'users.name',
                    DB::raw('SUM(overtimes.hours) as total_hours')
                )
                ->groupBy('users.name')
                ->get()
                ->map(function($s) use ($rate){
                    $s->total_rupiah = $s->total_hours * $rate;
                    return $s;
                });

            return view('admin.overtime',compact('data','summary','rate'));

        });

        Route::post('/overtime-rate', function(Request $request){

            DB::table('settings')->updateOrInsert(
                ['key'=>'overtime_rate'],
                ['value'=>$request->rate]
            );

            return back()->with('success','Tarif lembur berhasil disimpan');

        });

        /*
        | SCHEDULE MATRIX
        */

        Route::get('/schedule-matrix', function (Request $request) {

            $weekStart = $request->week_start ?? now()->startOfWeek()->format('Y-m-d');

            $staff = DB::table('users')->where('role','staff')->get();

            for($i=0;$i<7;$i++){
                $dates[] = date('Y-m-d',strtotime($weekStart." +$i day"));
            }
            $map = [];

            $raw = DB::table('schedule_details')
                ->join('shifts','shifts.id','=','schedule_details.shift_id')
                ->whereBetween('schedule_details.date',[$dates[0],$dates[6]])
                ->select(
                    'schedule_details.user_id',
                    'schedule_details.date',
                    'shifts.code'
                )
                ->get();

            foreach($raw as $r){
                $map[$r->user_id][$r->date] = $r->code;
            }

            return view('admin.schedule-matrix', compact('staff','dates','map','weekStart'));
        });

        /*
        |--------------------------------------------------------------------------
        | LEAVE ADMIN
        |--------------------------------------------------------------------------
        */

        // list cuti staff
        Route::get('/leave', function(){

            $data = DB::table('leaves')
                ->join('users','users.id','=','leaves.user_id')
                ->select(
                    'leaves.*',
                    'users.name'
                )
                ->orderByDesc('leaves.created_at')
                ->get();

            return view('admin.leave', compact('data'));

        })->name('admin.leave');


        // approve cuti
        Route::post('/leave/{id}/approve', function($id){

            DB::table('leaves')
                ->where('id',$id)
                ->update([
                    'status' => 'approved',
                    'reject_reason' => null,
                    'updated_at' => now()
                ]);

            return back()->with('success','Cuti disetujui');

        })->name('admin.leave.approve');


        // reject cuti + alasan
        Route::post('/leave/{id}/reject', function(Request $request,$id){

            DB::table('leaves')
                ->where('id',$id)
                ->update([
                    'status' => 'rejected',
                    'reject_reason' => $request->reason,
                    'updated_at' => now()
                ]);

            return back()->with('success','Cuti ditolak');

        })->name('admin.leave.reject');

        /*
        | OUTLET MANAGEMENT
        */

        Route::get('/outlet', function () {

            $outlet = DB::table('outlets')->first();

            return view('admin.outlet-management', compact('outlet'));
        });

        Route::post('/outlet', function (Request $request) {

            DB::table('outlets')->updateOrInsert(
                ['id'=>1],
                [
                    'name'=>$request->name,
                    'latitude'=>$request->latitude,
                    'longitude'=>$request->longitude,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]
            );

            return back()->with('success','Outlet berhasil disimpan');
        });

    });
/*
|--------------------------------------------------------------------------
| STAFF PANEL (MOBILE WEB APP)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:staff'])
    ->prefix('staff')
    ->group(function () {

    // INVENTORY MENU
    Route::get('/inventory', function(){
    return view('staff.inventory.index');
})->name('staff.inventory');

    // INVENTORY BOOK (MODAL FORM STYLE)
Route::prefix('inventory')->group(function(){


    // ================= WASTE =================
    Route::get('/waste',[WasteController::class,'index'])
        ->name('waste.index');

    Route::post('/waste',[WasteController::class,'store'])
        ->name('waste.store');

    Route::delete('/waste/{id}',[WasteController::class,'destroy'])
        ->name('waste.destroy');


    // ================= RETUR =================
    Route::get('/retur',[ReturController::class,'index'])
        ->name('retur.index');

    Route::post('/retur',[ReturController::class,'store'])
        ->name('retur.store');

    Route::delete('/retur/{id}',[ReturController::class,'destroy'])
        ->name('retur.destroy');


    // ================= STOCK =================
    Route::get('/stock',[StockController::class,'index'])
        ->name('stock.index');

    Route::post('/stock',[StockController::class,'store'])
        ->name('stock.store');

    Route::delete('/stock/{id}',[StockController::class,'destroy'])
        ->name('stock.destroy');


    // ================= BANTAI =================
    Route::get('/bantai',[BantaiController::class,'index'])
        ->name('bantai.index');

    Route::post('/bantai',[BantaiController::class,'store'])
        ->name('bantai.store');

    Route::delete('/bantai/{id}',[BantaiController::class,'destroy'])
        ->name('bantai.destroy');


    // ================= BARANG MASUK =================
    Route::get('/barang-masuk',[BarangMasukController::class,'index'])
        ->name('barangmasuk.index');

    Route::post('/barang-masuk',[BarangMasukController::class,'store'])
        ->name('barangmasuk.store');

    Route::delete('/barang-masuk/{id}',[BarangMasukController::class,'destroy'])
        ->name('barangmasuk.destroy');

        // ================= CHIPS (MASTER) =================
Route::get('/chips',[ChipController::class,'index'])
    ->name('chips.index');

Route::post('/chips',[ChipController::class,'store'])
    ->name('chips.store');

Route::delete('/chips/{id}',[ChipController::class,'destroy'])
    ->name('chips.destroy');

    Route::post('/chips-adjust/{id}',[ChipController::class,'adjustStock'])
    ->name('chips.adjust');

    // ================= CHIP SALES =================
Route::get('/chips-sales',[ChipSaleController::class,'index'])
    ->name('chips.sales.index');

Route::post('/chips-sales',[ChipSaleController::class,'store'])
    ->name('chips.sales.store');

Route::delete('/chips-sales/{id}',[ChipSaleController::class,'destroy'])
    ->name('chips.sales.destroy');

    // ================= PERGANTIAN TOPPING =================
Route::get('/topping-change',[ToppingChangeController::class,'index'])
    ->name('topping-change.index');

Route::post('/topping-change',[ToppingChangeController::class,'store'])
    ->name('topping-change.store');

Route::delete('/topping-change/{id}',[ToppingChangeController::class,'destroy'])
    ->name('topping-change.destroy');

});

        // Dashboard
        Route::get('/', function(){

            $userId = auth()->id();
            $today = now()->format('Y-m-d');

            $todayLabel = now()->translatedFormat('l, d F Y');

            // jadwal hari ini
            $schedule = DB::table('schedule_details')
                ->join('shifts','shifts.id','=','schedule_details.shift_id')
                ->where('schedule_details.user_id',$userId)
                ->where('schedule_details.date',$today)
                ->select('shifts.code')
                ->first();

            // absensi hari ini
            $attendance = DB::table('attendances')
                ->where('user_id',$userId)
                ->where('date',$today)
                ->first();

            if(!$schedule){
                $status = 'OFF';
            }elseif(!$attendance){
                $status = 'BELUM ABSEN';
            }else{
                $status = strtoupper($attendance->status);
            }

            $checkin = $attendance->checkin_time ?? '--:--';

            return view('staff.dashboard',compact(
                'status',
                'checkin',
                'todayLabel'
            ));

        })->name('staff.dashboard');

        // Scan QR
        Route::get('/scan', fn () => view('staff.scan'))->name('staff.scan');

        // Submit absensi
        Route::post('/absen',[AttendanceController::class,'store'])->name('staff.absen');

        // lembur
        Route::get('/overtime', function () {

            $rate = DB::table('settings')
                ->where('key','overtime_rate')
                ->value('value') ?? 0;

            $data = DB::table('overtimes')
                ->where('user_id',auth()->id())
                ->orderByDesc('date')
                ->get();

            $totalJam = $data->sum('hours');
            $totalRupiah = $totalJam * $rate;

            return view('staff.overtime',compact(
                'data',
                'rate',
                'totalJam',
                'totalRupiah'
            ));
        });

        Route::post('/overtime', function(Request $request){

            DB::table('overtimes')->insert([
                'user_id'=>auth()->id(),
                'date'=>$request->date,
                'hours'=>$request->hours,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);

            return back()->with('success','Lembur disimpan');

        })->name('staff.overtime');


        // Riwayat
        Route::get('/history', function () {

            $data = DB::table('attendances')
                ->join('shifts','shifts.id','=','attendances.shift_id')
                ->where('user_id',auth()->id())
                ->select(
                    'attendances.date',
                    'attendances.checkin_time',
                    'shifts.code as shift',
                    'attendances.status'
                )
                ->orderByDesc('attendances.date')
                ->get();

            return view('staff.history', compact('data'));

        })->name('staff.history');

        // PAYROLL STAFF (ABSENSI + CUTI APPROVED + LEMBUR)
        Route::get('/payroll', function(Request $request){

            $from = $request->from ?? now()->subMonth()->day(25)->format('Y-m-d');
            $to   = $request->to ?? now()->day(25)->format('Y-m-d');

            $user = auth()->user();

            /*
            |--------------------------------------------------------------------------
            | ATTENDANCE
            |--------------------------------------------------------------------------
            */
            $attendance = DB::table('attendances')
                ->where('user_id',$user->id)
                ->whereBetween('date',[$from,$to])
                ->pluck('date');

            /*
            |--------------------------------------------------------------------------
            | CUTI APPROVED (DIANGGAP HARI KERJA)
            |--------------------------------------------------------------------------
            */
            $leaves = DB::table('leaves')
                ->where('user_id',$user->id)
                ->where('status','approved')
                ->whereBetween('date',[$from,$to])
                ->pluck('date');

            $cutiCount = $leaves->count();

            /*
            |--------------------------------------------------------------------------
            | MERGE ABSENSI + CUTI
            |--------------------------------------------------------------------------
            */
            $dates = $attendance->merge($leaves);

            $weekday = 0;
            $weekend = 0;

            foreach($dates as $d){

                $day = date('w',strtotime($d));

                if($day==0 || $day==6){
                    $weekend++;
                }else{
                    $weekday++;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | LEMBUR
            |--------------------------------------------------------------------------
            */
            $overtimeHours = DB::table('overtimes')
                ->where('user_id',$user->id)
                ->whereBetween('date',[$from,$to])
                ->sum('hours');

            $overtimeRate = DB::table('settings')
                ->where('key','overtime_rate')
                ->value('value') ?? 0;

            return view('staff.payroll',compact(
                'weekday',
                'weekend',
                'cutiCount',
                'overtimeHours',
                'overtimeRate',
                'from',
                'to',
                'user'
            ));

        })->name('staff.payroll');


        // Jadwal
        Route::get('/schedule', function () {

            $data = DB::table('schedule_details')
                ->join('shifts','shifts.id','=','schedule_details.shift_id')
                ->where('schedule_details.user_id',auth()->id())
                ->select(
                    'schedule_details.date',
                    'shifts.code as shift'
                )
                ->orderBy('schedule_details.date')
                ->get();

            return view('staff.schedule', compact('data'));

        })->name('staff.schedule');

        /*
        |--------------------------------------------------------------------------
        | LEAVE STAFF
        |--------------------------------------------------------------------------
        */

        // halaman cuti staff
        Route::get('/leave', function(){

            $user = auth()->user();

            $data = DB::table('leaves')
                ->where('user_id',$user->id)
                ->orderByDesc('date')
                ->get();

            return view('staff.leave', compact('data'));

        })->name('staff.leave');


        // submit cuti
        Route::post('/leave', function(Request $request){

            DB::table('leaves')->insert([
                'user_id' => auth()->id(),
                'date' => $request->date,
                'reason' => $request->reason,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return back()->with('success','Pengajuan cuti berhasil dikirim');

        })->name('staff.leave.store');

        // PROFILE STAFF (custom blade)
        Route::get('/profile', fn () => view('profile.staff'))->name('staff.profile');

    });


/*
|--------------------------------------------------------------------------
| PROFILE (BREEZE)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class,'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
