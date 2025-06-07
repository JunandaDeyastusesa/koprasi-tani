<?php

namespace Database\Factories;

use App\Models\Mitra;
use Illuminate\Database\Eloquent\Factories\Factory;

class MitraFactory extends Factory
{
    protected $model = Mitra::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->company(),
            'email' => fake()->unique()->safeEmail(),
            'alamat' => $this->faker->address(),
            'no_hp' => $this->faker->phoneNumber(),
        ];
    }
}
