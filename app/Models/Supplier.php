<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

protected $fillable = [
    'nama_supplier',
    'no_hp',
    'alamat'
];

public function barangMasuk()
{
    return $this->hasMany(BarangMasukLog::class);
}

public function returs()
{
    return $this->hasMany(ReturLog::class);
}

public function wastes() // ← TAMBAHAN RELASI WASTE
{
    return $this->hasMany(WasteLog::class);
}

}

