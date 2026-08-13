<?php

namespace NuvisAccounting\Money\Rules;

use NuvisAccounting\Money\Currency;
use Illuminate\Contracts\Validation\Rule;

/**
 * @psalm-suppress DeprecatedInterface
 */
class CurrencyRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return is_string($value) && key_exists(strtoupper($value), Currency::getCurrencies());
    }

    public function message()
    {
        /** @var string */
        return trans('money.invalid-currency');
    }
}
