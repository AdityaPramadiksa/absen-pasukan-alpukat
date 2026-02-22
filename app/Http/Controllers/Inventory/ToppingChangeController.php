<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ToppingChangeLog;

class ToppingChangeController extends Controller
{

    // ================= INDEX =================
    public function index()
    {
        $logs = ToppingChangeLog::with('user')
                    ->latest()
                    ->get();

        return view('staff.inventory.topping-change.index', compact('logs'));
    }


    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'nama_toping_lama' => 'required|string|max:255',
            'berat_lama'       => 'required|numeric',
            'nama_toping_baru' => 'required|string|max:255',
            'berat_baru'       => 'required|numeric',
        ]);

        // 🔥 HANDLE FOTO
        $foto = $request->hasFile('foto')
            ? $request->file('foto')->store('topping-change','public')
            : null;

        ToppingChangeLog::create([
            'nama_toping_lama' => $request->nama_toping_lama,
            'berat_lama'       => $request->berat_lama,
            'nama_toping_baru' => $request->nama_toping_baru,
            'berat_baru'       => $request->berat_baru,
            'user_id'          => Auth::id(),
            'tanggal'          => now(),
            'foto'             => $foto,
            'keterangan'       => $request->keterangan,
        ]);

        return back()->with('success','Pergantian topping berhasil dicatat');
    }


    // ================= DESTROY =================
    public function destroy($id)
    {
        $log = ToppingChangeLog::findOrFail($id);

        // 🔥 HAPUS FOTO JIKA ADA
        if ($log->foto) {
            Storage::disk('public')->delete($log->foto);
        }

        $log->delete();

        return back()->with('success','Data pergantian topping dihapus');
    }

}
