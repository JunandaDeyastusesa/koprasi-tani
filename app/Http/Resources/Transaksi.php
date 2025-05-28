<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Transaksi extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'mitra' => new Mitra($this->whenLoaded('mitra')),
            'inventaris' => new Inventaris($this->whenLoaded('inventaris')),
            'jumlah' => $this->jumlah,
            'total_harga' => $this->total_harga,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
