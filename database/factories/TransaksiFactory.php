<?php

namespace Database\Factories;

use App\Models\Transaksi;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Inventaris;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    protected $model = Transaksi::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['Penjualan', 'Pembelian']);
        $jumlah = $this->faker->numberBetween(1, 10);
        $hargaSatuan = $this->faker->numberBetween(10000, 100000);

        return [
            'mitra_id' => Mitra::factory(),
            'user_id' => User::factory(),
            'inventari_id' => Inventaris::factory(),
            'jumlah' => $jumlah,
            'total_harga' => $jumlah * $hargaSatuan,
            'tgl_transaksi' => $this->faker->date(),
            'status' => $status,
        ];
    }
}
