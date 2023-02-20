<?php

namespace Xite\WiretablesMoney\Casts;

use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use RuntimeException;
use Throwable;
use Xite\WiretablesMoney\Traits\IsMoneyTrait;

class MoneyCast implements CastsAttributes
{
    use IsMoneyTrait;

    protected string $currency;

    public function __construct(?string $currency = null)
    {
        $this->currency = $currency ?? config('app.currency');
    }

    /**
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes):? Money
    {
        return Money::ofMinor($value, $this->getCurrencyValue($attributes));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        try {
            if (is_null($value)) {
                $value = Money::of(0, $this->getCurrencyValue($attributes));
            }

            $moneyValue = $this->money($value);

            if (array_key_exists($this->currency, $attributes)) {
                return [
                    $key => $moneyValue->getMinorAmount()->toInt(),
                    $this->currency => $moneyValue->getCurrency(),
                ];
            }

            return [
                $key => $moneyValue->getMinorAmount()->toInt()
            ];
        } catch (Throwable $exception) {
            throw new RuntimeException($exception->getMessage());
        }
   }

    private function getCurrencyValue($attributes)
    {
        if (Arr::has($attributes, $this->currency)) {
            return Arr::get($attributes, $this->currency) ?? config('app.currency');
        }

        return $this->currency;
    }
}
