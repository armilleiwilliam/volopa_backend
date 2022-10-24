<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

/**
 * Manage currency rates
 */
class ExchangeRateController extends Controller
{
    use ApiResponse;

    private array $currencies = ["USD", "GBP", "EUR", "AUD"];

    public function findExchangeRate(Request $request): JsonResponse
    {
        $errorMessage = "";
        $validation = Validator::make($request->all(),
            [
                "from_currency" => [Rule::in($this->currencies), "required"],
                "to_currency" => [Rule::in($this->currencies), "required", "different:from_currency"],
                "amount" => ["required", "regex:/^\d+(\.\d{1,2})?$/", "numeric"]
            ],[
                "to_currency.different" => "'To' and 'From' currencies must be different",
                "amount.regex" => "Amount format invalid, enter a decimal value (e.g.: 123.55). "
            ]);

        if (!$validation->fails()) {
            $findExchange = (new ExchangeRate())->findRate($request->from_currency, $request->to_currency);
            if(isset($findExchange->rate)){
                $amount_exchanged = $request->amount * $findExchange->rate;
                $finalCurrencyPrice = number_format($amount_exchanged, 2);
                return $this->success('success',
                    ['amount_exchanged' => $finalCurrencyPrice,
                        'rate' => $findExchange->rate,
                        'from_currency' => $request->from_currency,
                        'to_currency' => $request->to_currency,
                        'amount_to_exchange' => $request->amount]);
            } else {
                $errorMessage = "No rate found for these currencies";
            }
        } else {
            $errorMessage = $validation->messages();
        }

        return $this->error('Validation failed', $errorMessage, 200);
    }
}
