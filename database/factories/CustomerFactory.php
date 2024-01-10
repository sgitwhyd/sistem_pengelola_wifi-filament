<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'paket_id' => 1,
            'server_id' => 1,
            'name' => $this->faker->unique()->name,
            'alamat' => $this->faker->address,
            'no_hp' => $this->faker->phoneNumber,
            'ip_address' => $this->faker->unique()->ipv4,
        ];
    }
}
