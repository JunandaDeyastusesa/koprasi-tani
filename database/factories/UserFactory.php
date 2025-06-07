<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('password'), // password default 'password'
            'remember_token' => Str::random(10),
        ];
    }

    // State untuk role Member
    public function member()
    {
        return $this->afterCreating(function (User $user) {
            $role = Role::firstOrCreate(['nama' => 'Member']);
            $user->roles()->attach($role->id);
        });
    }

    // State untuk role Admin
    public function admin()
    {
        return $this->afterCreating(function (User $user) {
            $role = Role::firstOrCreate(['nama' => 'Admin']);
            $user->roles()->attach($role->id);
        });
    }
}
