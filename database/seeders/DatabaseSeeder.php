<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Paket;
use App\Models\Server;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

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
            'password' => bcrypt('12345678')
        ]);

        Company::factory()->create([
            'name' => 'JCOMP',
            'alamat' => 'Wonogiri',
            'no_telp' => '0812312323',
            'email' => 'testing@gmail.com'
        ]);
        

        Server::factory()->create([
            'name' => 'Wonogiri',
            'information' => 'Keterangan',
        ]);
        Paket::factory()->create([
            'name' => 'SOHO 5 Mbps',
            'price' => '150000',
            'information' => 'keterangan'
        ]);

        Customer::factory(10)->create();

        Transaction::factory(10)->create();
    }
}
