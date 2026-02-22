<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BantaiLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BantaiController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $logs = BantaiLog::with('user')
            ->latest()
            ->get();

        return view('staff.inventory.bantai.index', compact('logs'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'nama_item'     => 'required|string|max:255',
            'before_weight' => 'required|numeric',
            'after_weight'  => 'required|numeric',
            'foto_before'   => 'nullable|image|max:2048',
            'foto_after'    => 'nullable|image|max:2048',
        ]);

        // Upload Foto
        $fotoBefore = $request->hasFile('foto_before')
            ? $request->file('foto_before')->store('bantai', 'public')
            : null;

        $fotoAfter = $request->hasFile('foto_after')
            ? $request->file('foto_after')->store('bantai', 'public')
            : null;

        // Simpan Log
        BantaiLog::create([
            'nama_item'     => $request->nama_item,
            'user_id'       => Auth::id(),
            'tanggal'       => now(),
            'before_weight' => $request->before_weight,
            'after_weight'  => $request->after_weight,
            'foto_before'   => $fotoBefore,
            'foto_after'    => $fotoAfter,
        ]);

        return back()->with('success', 'Data bantai berhasil disimpan');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $log = BantaiLog::findOrFail($id);

        if ($log->foto_before) {
            Storage::disk('public')->delete($log->foto_before);
        }

        if ($log->foto_after) {
            Storage::disk('public')->delete($log->foto_after);
        }

        $log->delete();

        return back()->with('success', 'Data bantai dihapus');
    }
}
