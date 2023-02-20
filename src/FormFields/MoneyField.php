<?php

namespace Xite\WiretablesMoney\FormFields;

use Xite\Wireforms\Contracts\FieldContract;
use Xite\Wireforms\FormFields\FormField;
use Xite\WiretablesMoney\Components\Fields\Money;

class MoneyField extends FormField
{
    private bool $lazy = false;
    private ?float $min = null;
    private ?float $max = null;
    private float $step = 0.01;

    public function min(float $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function max(float $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function step(float $step): self
    {
        $this->step = $step;

        return $this;
    }

    public function lazy(): self
    {
        $this->lazy = true;

        return $this;
    }

    protected function render(): FieldContract
    {
        return Money::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            label: $this->label,
            help: $this->help,
            key: $this->key,
            placeholder: $this->placeholder,
            required: $this->required,
            disabled: $this->disabled,
            lazy: $this->lazy,
            min: $this->min,
            max: $this->max,
            step: $this->step
        );
    }
}
