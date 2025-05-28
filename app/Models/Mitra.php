<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'mitras';
    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
    ];


    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'mitra_id', 'id');
    }

}
