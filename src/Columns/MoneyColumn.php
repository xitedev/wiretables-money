<?php

namespace Xite\WiretablesMoney\Columns;

use Brick\Money\Money;
use Illuminate\Contracts\View\View;
use NumberFormatter;
use Xite\Wiretables\Columns\Column;

class MoneyColumn extends Column
{
    private bool $hideSymbol = false;
    private bool $showSign = false;
    private bool $hideZero = false;

    protected array $class = ['font-bold'];

    public function hideSymbol(): self
    {
        $this->hideSymbol = true;

        return $this;
    }

    public function hideZero(): self
    {
        $this->hideZero = true;

        return $this;
    }

    public function showSign(): self
    {
        $this->showSign = true;

        return $this;
    }

    public function getAmount(Money $value): string
    {
        if ($this->showSign && $value->isNegative()) {
            $value = $value->abs();
        }

        $formatter = new NumberFormatter('ru_RU', NumberFormatter::CURRENCY);
        $formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, 2);

        if ($this->hideSymbol) {
            $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
            $formatter->setSymbol(NumberFormatter::INTL_CURRENCY_SYMBOL, '');
        }

        return $value->formatWith($formatter);
    }

    protected function getValue($row)
    {
        return $row->{$this->getName()};
    }

    public function canDisplay($row): bool
    {
        if (! parent::canDisplay($row)) {
            return false;
        }

        $value = $this->displayData($row);

        if (! $value instanceof Money) {
            return false;
        }

        if ($this->hideZero && $value->isZero()) {
            return false;
        }

        return true;
    }

    public function renderIt($row): ?string
    {
        $value = $this->displayData($row);

        return $this
            ->render()
            ?->with([
                'id' => $row->getKey(),
                'name' => $this->getName(),
                'data' => $value,
                'showSign' => $this->showSign,
                'amount' => $this->getAmount($value),
            ])
            ->render();
    }

    public function render(): ?View
    {
        return view('wiretables-money::columns.money-column');
    }
}
