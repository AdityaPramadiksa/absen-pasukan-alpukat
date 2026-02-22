<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteLog extends Model
{
    use HasFactory;

    protected $fillable = [
    'nama_item',
    'supplier_id',
    'user_id',
    'tanggal',
    'berat',
    'foto',
    'keterangan'
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function supplier()
{
    return $this->belongsTo(Supplier::class);
}

}
