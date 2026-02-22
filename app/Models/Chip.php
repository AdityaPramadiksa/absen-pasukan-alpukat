<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chip extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_chips',
        'qty_stock', // 🔥 WAJIB ditambahkan
    ];

    // ================= RELATION =================
    public function sales()
    {
        return $this->hasMany(ChipSale::class);
    }

    // ================= HELPER (OPTIONAL PRO) =================
    // cek stok habis
    public function isOutOfStock()
    {
        return $this->qty_stock <= 0;
    }

    // cek stok rendah (untuk UI nanti)
    public function isLowStock()
    {
        return $this->qty_stock <= 5;
    }
}
