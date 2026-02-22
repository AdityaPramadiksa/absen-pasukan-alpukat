<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_item', // ← LOGBOOK MODE
        'user_id',
        'tanggal',
        'shift',
        'stok_before',
        'stok_after',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
