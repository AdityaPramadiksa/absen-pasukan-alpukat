<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        return view('admin.suppliers',
            compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier'=>'required|string|max:255'
        ]);

        Supplier::create([
            'nama_supplier'=>$request->nama_supplier,
            'no_hp'=>$request->no_hp,
            'alamat'=>$request->alamat
        ]);

        return back()->with('success','Supplier berhasil ditambahkan');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();

        return back()->with('success','Supplier dihapus');
    }
}
