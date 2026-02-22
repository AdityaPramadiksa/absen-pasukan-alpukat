<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasukLog;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    public function index()
    {
        $logs = BarangMasukLog::with('supplier','user')
            ->latest()
            ->get();

        $suppliers = Supplier::all();

        return view('staff.inventory.barang_masuk.index',
            compact('logs','suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'qty'       => 'required|numeric',
        ]);

        $foto = $request->hasFile('foto')
            ? $request->file('foto')->store('barang_masuk','public')
            : null;

        BarangMasukLog::create([
            'nama_item'  => $request->nama_item,
            'supplier_id'=> $request->supplier_id,
            'user_id'    => Auth::id(),
            'tanggal'    => now(),
            'qty'        => $request->qty,
            'foto'       => $foto,
            'catatan'    => $request->catatan,
        ]);

        return back()->with('success','Barang masuk berhasil disimpan');
    }
    public function destroy($id)
{
    $log = BarangMasukLog::findOrFail($id);

    if ($log->foto) {
        \Storage::disk('public')->delete($log->foto);
    }

    $log->delete();

    return back()->with('success','Barang masuk dihapus');
}

}
