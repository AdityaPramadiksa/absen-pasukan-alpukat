<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReturLog;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class ReturController extends Controller
{
    public function index()
    {
        $logs = ReturLog::with('supplier','user')
            ->latest()
            ->get();

        $suppliers = Supplier::all();

        return view('staff.inventory.retur.index',
            compact('logs','suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'berat'     => 'required|numeric',
        ]);

        $foto = $request->hasFile('foto')
            ? $request->file('foto')->store('retur','public')
            : null;

        ReturLog::create([
            'nama_item'  => $request->nama_item,
            'supplier_id'=> $request->supplier_id,
            'user_id'    => Auth::id(),
            'tanggal'    => now(),
            'berat'      => $request->berat,
            'foto'       => $foto,
            'alasan'     => $request->alasan,
        ]);

        return back()->with('success','Data retur berhasil disimpan');
    }
    public function destroy($id)
{
    $log = ReturLog::findOrFail($id);

    if ($log->foto) {
        \Storage::disk('public')->delete($log->foto);
    }

    $log->delete();

    return back()->with('success','Retur berhasil dihapus');
}

}
