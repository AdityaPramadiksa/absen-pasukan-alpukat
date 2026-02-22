<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_item', // ← GANTI
        'supplier_id',
        'user_id',
        'tanggal',
        'berat',
        'foto',
        'alasan'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
