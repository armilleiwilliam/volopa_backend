<?php

namespace App\Models;

use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ExchangeRate extends Model
{
    use HasFactory;

    use ApiResponse;

    public $timestamps = true;

    // We override the constructor to set if given the default 'from'
    // and 'to' currencies values
    public function __construct(array $attributes = array(),$from = null, $to = null)
    {
        parent::__construct($attributes);

        if ($from && $to) {
            $this->from_currency = $from;
            $this->to_currency = $to;
        }
    }

    protected $table = 'exchange_rates';

    public array $currencies = ["USD", "GBP", "EUR", "AUD"];

    protected $fillable = ['from_currency', 'to_currency', 'rate', 'since',
        'until', 'created_at', 'updated_at', 'deleted_at'];

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }

    public function findRate($from, $to)
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

    public function lastExchange($by = null): self
    {
        // Retrieving the last record for the given from and to values set when
        // the model was instantiated

        // If a top date is set, we retrieve the most recent value by the given date
        if ($by) {
            return self::where('from_currency', $this->from_currency)
                ->where('to_currency', $this->to_currency)
                ->where('until', '<=', $by)
                ->orderBy('until', 'DESC')
                ->get()->first();
        } else {
            // Else, we retrive the current stored value
            return self::where('from_currency', $this->from_currency)
                ->where('to_currency', $this->to_currency)
                ->whereNull('until')
                ->get()->first();
        }
    }

    // A method for direct exchange rate calculation
    public function convert($value, $by = null): self
    {
        return $this->lastExchange($by)->rate * $value;
    }
}
