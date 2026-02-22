<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BantaiLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_item', // ← LOGBOOK MODE
        'user_id',
        'tanggal',
        'before_weight',
        'waste_weight',
        'retur_weight',
        'after_weight',
        'foto_before',
        'foto_after'
    ];

    // RELASI USER SAJA
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
