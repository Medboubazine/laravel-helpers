<?php

namespace Medboubazine\LaravelHelpers\Models;

use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

#[Fillable(["from_amount", "from_currency", "to_amount", "to_currency"])]
#[Appends(["rate"])]
#[Hidden([])]
class ExchangeRate extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'from_amount' => 'decimal:18',
            'to_amount' => 'decimal:18',
        ];
    }

    /**
     * Interact with the exchange rate attribute.
     */
    protected function rate(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $from_amount = isset($attributes['from_amount']) && $attributes['from_amount'] > 0
                    ? $attributes['from_amount']
                    : '1';

                $to_amount = $attributes['to_amount'] ?? '0';

                return bcdiv((string) $to_amount, (string) $from_amount, 18);
            }
        );
    }

    /**
     * Get the available currencies.
     *
     * @return array<int, string>
     */
    public static function currencies(): array
    {
        return ['DZD', 'USD', 'EUR']; // Currencies must be uppercase
    }
}
