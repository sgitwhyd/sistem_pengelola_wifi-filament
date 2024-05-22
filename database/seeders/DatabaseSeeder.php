<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Paket;
use App\Models\Server;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);

        Company::factory()->create([
            'name' => 'Fanayu Daya Network',
            'alamat' => 'Sragen',
            'no_telp' => '0812312323',
            'email' => 'fanayudayanetwork@gmail.com'
        ]);


        for ($i = 1; $i <= 5; $i++) {
            Server::factory()->create([
                'name' => 'Wonogiri ' . $i,
                'information' => 'Keterangan',
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            Paket::factory()->create([
                'name' => 'SOHO ' . $i . '0 Mbps',
                'price' => '1' . $i . '0000',
                'information' => 'keterangan'
            ]);
        }


        for ($i = 1; $i <= 30; $i++) {
            Customer::factory()->create([
                'name' => 'Customer ' . $i,
                'alamat' => 'Alamat ' . $i,
                'no_hp' => '0812312323' . $i,
                'ip_address' => '192.168.1.' . $i,
                'paket_id' => rand(1, 5),
                'server_id' => rand(1, 5),
            ]);
        }

        $monthMinesOne = Carbon::now()->subMonth()->monthName;

        for ($i = 1; $i <= 30; $i++) {
            $num = rand(1, 5);
            Transaction::factory()->create([
                'customer_id' => $i,
                'payment_proof_image' => 'payment_proof_image.jpg',
                'paket' => 'SOHO ' . $num . '0 Mbps',
                'status' => 'paid',
                'package_price' => intval('1' . $num . '0000'),
                'payment_month' => $monthMinesOne,
                'payment_year' => '2024'
            ]);
        }
    }
}
