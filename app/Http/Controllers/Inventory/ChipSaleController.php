<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChipSale;
use App\Models\Chip;

class ChipSaleController extends Controller
{
    public function index()
    {
        $chips = Chip::latest()->get();

        $sales = ChipSale::with('chip','user')
                    ->latest()
                    ->get();

        return view('staff.inventory.chips.sales', compact('chips','sales'));
    }


    // ================= STORE SALE (KASIR MODE) =================
    public function store(Request $request)
    {
        $request->validate([
            'chip_id'      => 'required|exists:chips,id',
            'qty'          => 'required|numeric|min:1',
            'metode_bayar' => 'required|in:cash,debit,kredit,qris'
        ]);

        $chip = Chip::findOrFail($request->chip_id);

        // ================= CEK STOK =================
        if($chip->qty_stock <= 0){
            return back()->with('error','Stok chips habis!');
        }

        if($chip->qty_stock < $request->qty){
            return back()->with('error','Qty melebihi stok tersedia!');
        }

        // ================= KURANGI STOK =================
        $chip->decrement('qty_stock', $request->qty);

        // ================= SIMPAN TRANSAKSI =================
        ChipSale::create([
            'chip_id'      => $chip->id,
            'user_id'      => Auth::id(),
            'qty'          => $request->qty,
            'metode_bayar' => $request->metode_bayar,
            'tanggal'      => now(),
        ]);

        return back()->with('success','Penjualan chips berhasil dicatat');
    }


    // ================= DELETE SALE (RESTORE STOCK) =================
    public function destroy($id)
    {
        $sale = ChipSale::findOrFail($id);

        // BALIKKAN STOK (karena transaksi dihapus)
        $sale->chip->increment('qty_stock', $sale->qty);

        $sale->delete();

        return back()->with('success','Data penjualan dihapus & stok dikembalikan');
    }
}
