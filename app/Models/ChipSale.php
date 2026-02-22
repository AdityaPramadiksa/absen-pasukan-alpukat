<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChipSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'chip_id',
        'user_id',
        'qty',
        'metode_bayar',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'datetime', // 🔥 biar format Carbon otomatis
    ];

    // ================= RELATION =================

    public function chip()
    {
        return $this->belongsTo(Chip::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
