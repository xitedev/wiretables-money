<?php

namespace Xite\WiretablesMoney\Rules;

use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Xite\WiretablesMoney\Traits\IsMoneyTrait;

class MoneyNotZeroRule implements ValidationRule
{
    use IsMoneyTrait;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $moneyValue = $this->money($value);

            if ($moneyValue->isZero()) {
                $fail('validation.not_zero');
            }
        } catch (Exception $exception) {
            $fail($exception->getMessage());
        }
    }
}
