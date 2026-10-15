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
        return [];
    }
    /**
     * ->rate.
     */
    protected function rate(): Attribute
    {
        $from_amount = $this->from_amount > 0 ? $this->from_amount : 1;
        $to_amount = $this->to_amount;

        $rate = bcdiv($to_amount, $from_amount, 18);

        return Attribute::get(
            fn(mixed $value, array $attributes) => $rate
        );
    }
    /**
     * Get the availlable currencies.
     *
     * @return array<string, string>
     */
    public static function currencies(): array
    {
        return ['DZD', 'USD', 'EUR']; //Currencies must be uppercase
    }
}
