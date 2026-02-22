<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WasteLog;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class WasteController extends Controller
{

public function index()
{
    // ambil data waste + relasi supplier & user
    $logs = WasteLog::with('supplier','user')
        ->latest()
        ->get();

    // ambil list supplier untuk dropdown form
    $suppliers = Supplier::all();

    return view('staff.inventory.waste.index',
        compact('logs','suppliers'));
}
public function store(Request $request)
{
    $request->validate([
        'nama_item'   => 'required|string|max:255',
        'supplier_id' => 'nullable|exists:suppliers,id',
        'berat'      => 'nullable|numeric|min:0',
        'satuan'      => 'nullable|in:kg,gram',
        'foto'        => 'nullable|image'
    ]);

    // 🔥 convert ke gram kalau input kg
    $berat = $request->berat;

    if ($request->satuan == 'kg') {
        $berat = $berat * 1000;
    }

    $fotoPath = $request->hasFile('foto')
        ? $request->file('foto')->store('waste','public')
        : null;

    WasteLog::create([
        'nama_item'   => $request->nama_item,
        'supplier_id' => $request->supplier_id,
        'user_id'     => Auth::id(),
        'tanggal'     => now(),
        'berat'      => $berat, // 🔥 INI YANG TADI BELUM ADA
        'foto'        => $fotoPath,
        'keterangan'  => $request->keterangan,
    ]);

    return back()->with('success','Data waste berhasil disimpan');
}


    public function destroy($id)
{
    $log = WasteLog::findOrFail($id);

    if ($log->foto) {
        \Storage::disk('public')->delete($log->foto);
    }

    $log->delete();

    return back()->with('success','Waste berhasil dihapus');
}

}
