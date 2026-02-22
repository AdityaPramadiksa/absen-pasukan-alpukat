<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasukLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_item', // ← STRING
        'supplier_id',
        'user_id',
        'tanggal',
        'qty',
        'foto',
        'catatan'
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
