<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StockController extends Controller
{
    public function index()
    {
        $logs = StockLog::with('user')
            ->latest()
            ->get();

        return view('staff.inventory.stock.index', compact('logs'));
    }


    public function store(Request $request)
    {
        // ================= VALIDATION =================
        $request->validate([
            'nama_item'   => 'required|string|max:255',
            'shift'       => 'required|in:pagi,malam',
            'stok_before' => 'nullable|numeric',
            'stok_after'  => 'nullable|numeric',
            'foto'        => 'nullable|image|max:2048'
        ]);

        // ================= FOTO =================
        $foto = $request->hasFile('foto')
            ? $request->file('foto')->store('stock', 'public')
            : null;

        // ================= SHIFT LOGIC =================
        $stokBefore = null;
        $stokAfter  = null;

        if ($request->shift === 'pagi') {
            $stokBefore = $request->stok_before;
        }

        if ($request->shift === 'malam') {
            $stokAfter = $request->stok_after;
        }

        // ================= SAVE =================
        StockLog::create([
            'nama_item'   => $request->nama_item,
            'user_id'     => Auth::id(),
            'tanggal'     => now(),
            'shift'       => $request->shift,
            'stok_before' => $stokBefore,
            'stok_after'  => $stokAfter,
            'foto'        => $foto,
        ]);

        return back()->with('success', 'Stok berhasil dicatat');
    }


    public function destroy($id)
    {
        $log = StockLog::findOrFail($id);

        if ($log->foto) {
            Storage::disk('public')->delete($log->foto);
        }

        $log->delete();

        return back()->with('success', 'Stok berhasil dihapus');
    }
}
