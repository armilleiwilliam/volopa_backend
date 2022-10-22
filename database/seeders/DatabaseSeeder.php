<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Create seeds for both table Exchange rate and User
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            ExchangeRateSeeder::class
        ]);

        User::factory(1)->create(
            ["password" => bcrypt('password')]
        );
    }
}
