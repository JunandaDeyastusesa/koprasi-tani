<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaksi;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Inventaris;

class TransaksiFactory extends Factory
{
    protected $model = Transaksi::class;

    public function definition()
    {
        // Ambil data id mitra, user, dan inventaris secara random jika ada
        $mitraId = Mitra::inRandomOrder()->value('id');
        $userId = User::inRandomOrder()->value('id');
        $inventarisId = Inventaris::inRandomOrder()->value('id');

        // Status bisa "Penjualan" atau "Pembelian"
        $status = $this->faker->randomElement(['Penjualan', 'Pembelian']);

        // Jumlah barang transaksi (1-10)
        $jumlah = $this->faker->numberBetween(1, 10);

        // Harga total (misal harga satuan 10000 dikali jumlah)
        $hargaSatuan = 10000;
        $totalHarga = $jumlah * $hargaSatuan;

        return [
            'mitra_id' => $mitraId,
            'user_id' => $userId,
            'inventari_id' => $inventarisId,
            'jumlah' => $jumlah,
            'total_harga' => $totalHarga,
            'tgl_transaksi' => $this->faker->date(),
            'status' => $status,
        ];
    }
}
