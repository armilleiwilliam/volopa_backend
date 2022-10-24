<?php

namespace App\Models;

use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class ExchangeRate extends Model
{
    use HasFactory;
    use ApiResponse;

    public $timestamps = true;

    public array $currencies = ["USD", "GBP", "EUR", "AUD"];

    protected $fillable = ['from_currency', 'to_currency', 'rate', 'since',
        'until', 'created_at', 'updated_at', 'deleted_at'];

    public function findRate($from, $to): JsonResponse|ExchangeRate
    {
        if(in_array($to, $this->currencies) && in_array($from, $this->currencies)){
            return ExchangeRate::where(
                [
                    "to_currency" => $to,
                    "from_currency" => $from
                ]
            )->first();
        }
        return $this->error("Currency not found", [], 404);
    }
}
