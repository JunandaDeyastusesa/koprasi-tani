<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MitraFactory extends Factory
{
    protected $model = \App\Models\Mitra::class;

    public function definition()
    {
        return [
            'id' => strtolower((string) Str::ulid()),
            'nama' => $this->faker->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'no_hp' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
        ];
    }
}
