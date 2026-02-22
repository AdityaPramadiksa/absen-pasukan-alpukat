<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToppingChangeLog extends Model
{
    use HasFactory;

    protected $table = 'topping_change_logs';

    protected $fillable = [
        'nama_toping_lama',
        'berat_lama',
        'nama_toping_baru',
        'berat_baru',
        'user_id',
        'tanggal',
        'foto',
        'keterangan',
    ];

    // 🔥 AUTO CARBON DATE
    protected $casts = [
        'tanggal' => 'datetime',
    ];

    // ================= RELATION =================
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
