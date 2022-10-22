<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExchangeRate;
use Illuminate\Support\Carbon;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Seeder currency rates
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["from_currency" => "EUR", "to_currency" => "GBP", "rate" => 0.89, "since" => Carbon::today(), "until" => Carbon::tomorrow()],
            ["from_currency" => "EUR", "to_currency" => "USD", "rate" => 1.10, "since" => Carbon::today(), "until" => Carbon::tomorrow()],
            ["from_currency" => "EUR", "to_currency" => "AUD", "rate" => 0.70, "since" => Carbon::today(), "until" => Carbon::tomorrow()],
            ["from_currency" => "GBP", "to_currency" => "EUR", "rate" => 1.11, "since" => Carbon::today(), "until" => Carbon::tomorrow()],
            ["from_currency" => "GBP", "to_currency" => "USD", "rate" => 1.30, "since" => Carbon::today(), "until" => Carbon::tomorrow()],
            ["from_currency" => "GBP", "to_currency" => "AUD", "rate" => 1.20, "since" => Carbon::today(), "until" => Carbon::tomorrow()],
            ["from_currency" => "USD", "to_currency" => "GBP", "rate" => 1.50, "since" => Carbon::today(), "until" => Carbon::tomorrow()],
            ["from_currency" => "USD", "to_currency" => "EUR", "rate" => 1.30, "since" => Carbon::today(), "until" => Carbon::tomorrow()],
            ["from_currency" => "USD", "to_currency" => "AUD", "rate" => 1.05, "since" => Carbon::today(), "until" => Carbon::tomorrow()],
            ["from_currency" => "AUD", "to_currency" => "GBP", "rate" => 0.80, "since" => Carbon::today(), "until" => Carbon::tomorrow()],
            ["from_currency" => "AUD", "to_currency" => "EUR", "rate" => 0.90, "since" => Carbon::today(), "until" => Carbon::tomorrow()],
            ["from_currency" => "AUD", "to_currency" => "USD", "rate" => 1.05, "since" => Carbon::today(), "until" => Carbon::tomorrow()],
        ];
        ExchangeRate::insert($data);
    }
}
