<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        Carbon::setLocale('id-ID');

        $month = Carbon::now()->monthName;
        $monthMinesOne = Carbon::now()->subMonth()->monthName;

        return [
            'customer_id' => $this->faker->numberBetween(1, 10),
            'payment_proof_image' => 'payment_proof_image.jpg',
            'paket' => 'SOHO 5 Mbps',
            'status' => 'pending',
            'package_price' => 150000,
            'payment_month' => $monthMinesOne,
            'payment_year' => '2024'
        ];
    }
}
