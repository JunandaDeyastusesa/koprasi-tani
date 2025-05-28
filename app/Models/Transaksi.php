<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'transaksis';
    protected $fillable = [
        'mitra_id',
        'inventari_id',
        'jumlah',
        'total_harga',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id', 'id');
    }
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class, 'inventari_id', 'id');
    }
}
