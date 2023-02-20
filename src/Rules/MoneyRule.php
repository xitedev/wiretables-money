<?php

namespace Xite\WiretablesMoney\Rules;

use Brick\Math\Exception\MathException;
use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\MoneyMismatchException;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\Money;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use RuntimeException;
use Throwable;
use Xite\WiretablesMoney\Traits\IsMoneyTrait;

class MoneyRule implements ValidationRule
{
    use IsMoneyTrait;

    private ?float $min;
    private ?float $max;

    public function __construct(?float $min = null, ?float $max = null)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $moneyValue = $this->money($value);

            $this->isValueLessThanMin($moneyValue);
            $this->isValueGreaterThanMin($moneyValue);

        } catch (Throwable $exception) {
            $fail($exception->getMessage());
        }
    }

    /**
     * @throws Throwable
     * @throws RoundingNecessaryException
     * @throws MoneyMismatchException
     * @throws MathException
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     */
    private function isValueLessThanMin(Money $moneyValue): void
    {
        if (!$this->min) {
            return;
        }

        $minAmount = Money::of($this->min, $moneyValue->getCurrency());

        throw_if(
            $moneyValue->isLessThan($minAmount),
            new RuntimeException(__('validation.between.numeric', ['min' => $this->min, 'max' => $this->max]))
        );
    }

    /**
     * @throws Throwable
     * @throws RoundingNecessaryException
     * @throws MoneyMismatchException
     * @throws MathException
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     */
    private function isValueGreaterThanMin(Money $moneyValue): void
    {
        if (!$this->max) {
            return;
        }

        $maxAmount = Money::of($this->max, $moneyValue->getCurrency());

        throw_if(
            $moneyValue->isGreaterThan($maxAmount),
            new RuntimeException(__('validation.between.numeric', ['min' => $this->min, 'max' => $this->max]))
        );
    }
}
