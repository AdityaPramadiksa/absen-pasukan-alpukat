<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BantaiLog;
use Illuminate\Support\Facades\Auth;

class BantaiController extends Controller
{
    public function index()
    {
        $logs = BantaiLog::with('user')
            ->latest()
            ->get();

        return view('staff.inventory.bantai.index',
            compact('logs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_item'     => 'required|string|max:255',
            'before_weight' => 'required|numeric',
        ]);

        $after = $request->before_weight
            - ($request->waste_weight ?? 0)
            - ($request->retur_weight ?? 0);

        $fotoBefore = $request->hasFile('foto_before')
            ? $request->file('foto_before')->store('bantai','public')
            : null;

        $fotoAfter = $request->hasFile('foto_after')
            ? $request->file('foto_after')->store('bantai','public')
            : null;

        BantaiLog::create([
            'nama_item'     => $request->nama_item,
            'user_id'       => Auth::id(),
            'tanggal'       => now(),
            'before_weight' => $request->before_weight,
            'waste_weight'  => $request->waste_weight ?? 0,
            'retur_weight'  => $request->retur_weight ?? 0,
            'after_weight'  => $after,
            'foto_before'   => $fotoBefore,
            'foto_after'    => $fotoAfter,
        ]);

        return back()->with('success','Data bantai berhasil disimpan');
    }
    public function destroy($id)
{
    $log = BantaiLog::findOrFail($id);

    if ($log->foto_before) {
        \Storage::disk('public')->delete($log->foto_before);
    }

    if ($log->foto_after) {
        \Storage::disk('public')->delete($log->foto_after);
    }

    $log->delete();

    return back()->with('success','Data bantai dihapus');
}

}
