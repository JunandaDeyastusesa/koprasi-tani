<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Inventaris extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'inventaries';

    protected $fillable = [
        'nama',
        'kategori',
        'harga_beli',
        'herga_jual',
        'jumlah',
        'deskripsi',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'inventari_id', 'id');
    }
}
