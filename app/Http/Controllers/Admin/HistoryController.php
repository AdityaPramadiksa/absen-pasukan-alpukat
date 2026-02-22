<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $from = $request->from;
        $to   = $request->to;

        $logs = collect();

        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK
        |--------------------------------------------------------------------------
        */
        if(!$type || $type == 'masuk'){

            $query = DB::table('barang_masuk_logs')
                ->join('users','users.id','=','barang_masuk_logs.user_id')
                ->select(
                    'barang_masuk_logs.tanggal',
                    'users.name',
                    DB::raw("'masuk' as tipe"),
                    'barang_masuk_logs.nama_item as deskripsi',
                    'barang_masuk_logs.foto as foto'
                );

            if($from) $query->whereDate('barang_masuk_logs.tanggal','>=',$from);
            if($to)   $query->whereDate('barang_masuk_logs.tanggal','<=',$to);

            $logs = $logs->merge($query->get());
        }

        /*
        |--------------------------------------------------------------------------
        | WASTE
        |--------------------------------------------------------------------------
        */
        if(!$type || $type == 'waste'){

            $query = DB::table('waste_logs')
                ->join('users','users.id','=','waste_logs.user_id')
                ->select(
                    'waste_logs.tanggal',
                    'users.name',
                    DB::raw("'waste' as tipe"),
                    'waste_logs.nama_item as deskripsi',
                    'waste_logs.foto as foto'
                );

            if($from) $query->whereDate('waste_logs.tanggal','>=',$from);
            if($to)   $query->whereDate('waste_logs.tanggal','<=',$to);

            $logs = $logs->merge($query->get());
        }

        /*
        |--------------------------------------------------------------------------
        | BANTAI
        |--------------------------------------------------------------------------
        */
        if(!$type || $type == 'bantai'){

            $query = DB::table('bantai_logs')
                ->join('users','users.id','=','bantai_logs.user_id')
                ->select(
                    'bantai_logs.tanggal',
                    'users.name',
                    DB::raw("'bantai' as tipe"),
                    'bantai_logs.nama_item as deskripsi',
                    DB::raw("COALESCE(bantai_logs.foto_after, bantai_logs.foto_before) as foto")
                );

            if($from) $query->whereDate('bantai_logs.tanggal','>=',$from);
            if($to)   $query->whereDate('bantai_logs.tanggal','<=',$to);

            $logs = $logs->merge($query->get());
        }

        /*
        |--------------------------------------------------------------------------
        | RETUR
        |--------------------------------------------------------------------------
        */
        if(!$type || $type == 'retur'){

            $query = DB::table('retur_logs')
                ->join('users','users.id','=','retur_logs.user_id')
                ->select(
                    'retur_logs.tanggal',
                    'users.name',
                    DB::raw("'retur' as tipe"),
                    'retur_logs.nama_item as deskripsi',
                    'retur_logs.foto as foto'
                );

            if($from) $query->whereDate('retur_logs.tanggal','>=',$from);
            if($to)   $query->whereDate('retur_logs.tanggal','<=',$to);

            $logs = $logs->merge($query->get());
        }

        /*
        |--------------------------------------------------------------------------
        | STOCK
        |--------------------------------------------------------------------------
        */
        if(!$type || $type == 'stock'){

            $query = DB::table('stock_logs')
                ->join('users','users.id','=','stock_logs.user_id')
                ->select(
                    'stock_logs.tanggal',
                    'users.name',
                    DB::raw("'stock' as tipe"),
                    'stock_logs.nama_item as deskripsi',
                    'stock_logs.foto as foto'
                );

            if($from) $query->whereDate('stock_logs.tanggal','>=',$from);
            if($to)   $query->whereDate('stock_logs.tanggal','<=',$to);

            $logs = $logs->merge($query->get());
        }

        /*
        |--------------------------------------------------------------------------
        | CHIP SALES (BARU 🔥)
        |--------------------------------------------------------------------------
        */
        if(!$type || $type == 'chips'){

            $query = DB::table('chip_sales')
                ->join('users','users.id','=','chip_sales.user_id')
                ->join('chips','chips.id','=','chip_sales.chip_id')
                ->select(
                    'chip_sales.tanggal',
                    'users.name',
                    DB::raw("'chips' as tipe"),
                    DB::raw("CONCAT(chips.nama_chips,' (',chip_sales.qty,' pcs - ',chip_sales.metode_bayar,')') as deskripsi"),
                    DB::raw("NULL as foto")
                );

            if($from) $query->whereDate('chip_sales.tanggal','>=',$from);
            if($to)   $query->whereDate('chip_sales.tanggal','<=',$to);

            $logs = $logs->merge($query->get());
        }

        /*
        |--------------------------------------------------------------------------
        | SORT TERBARU
        |--------------------------------------------------------------------------
        */
        $logs = $logs->sortByDesc('tanggal')->values();

        return view('admin.history', compact('logs','type','from','to'));
    }
}
