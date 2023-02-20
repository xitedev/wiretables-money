<?php

namespace Xite\WiretablesMoney\Traits;

use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\Money;
use InvalidArgumentException;
use JsonException;

trait IsMoneyTrait
{

    /**
     * @throws RoundingNecessaryException
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     * @throws JsonException
     */
    protected function money(mixed $value): Money
    {
        if ($value instanceof Money) {
            return $value;
        }

        if (is_string($value)) {
            $value = json_decode($value, true, 512, JSON_THROW_ON_ERROR);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new InvalidArgumentException('The given string is not an Json instance.');
            }
        }

        if (!is_array($value) && !array_key_exists('amount', $value)) {
            throw new InvalidArgumentException('The given value is not an Money instance.');
        }

        return Money::of($value['amount'], $value['currency'] ?? config('app.currency'));
    }
}
