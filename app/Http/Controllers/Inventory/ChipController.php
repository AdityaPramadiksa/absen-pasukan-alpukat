<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chip;

class ChipController extends Controller
{
    public function index()
    {
        $chips = Chip::latest()->get();

        return view('staff.inventory.chips.index', compact('chips'));
    }


    // ================= TAMBAH CHIPS =================
    public function store(Request $request)
    {
        $request->validate([
            'nama_chips' => 'required|string|max:255',
            'qty_stock'  => 'required|numeric|min:0',
        ]);

        Chip::create([
            'nama_chips' => $request->nama_chips,
            'qty_stock'  => $request->qty_stock,
        ]);

        return back()->with('success','Chips berhasil ditambahkan');
    }


    // ================= UPDATE NAMA + STOK =================
    public function update(Request $request, $id)
    {
        $chip = Chip::findOrFail($id);

        $request->validate([
            'nama_chips' => 'required|string|max:255',
            'qty_stock'  => 'required|numeric|min:0',
        ]);

        $chip->update([
            'nama_chips' => $request->nama_chips,
            'qty_stock'  => $request->qty_stock,
        ]);

        return back()->with('success','Chips berhasil diupdate');
    }


    // ================= ADJUST STOCK CEPAT (OPSIONAL PRO) =================
    // untuk tombol + / - stok tanpa edit nama
    public function adjustStock(Request $request, $id)
    {
        $chip = Chip::findOrFail($id);

        $request->validate([
            'qty_stock' => 'required|numeric|min:0',
        ]);

        $chip->update([
            'qty_stock' => $request->qty_stock
        ]);

        return back()->with('success','Stok berhasil disesuaikan');
    }


    // ================= HAPUS =================
    public function destroy($id)
    {
        $chip = Chip::findOrFail($id);
        $chip->delete();

        return back()->with('success','Chips berhasil dihapus');
    }
}
