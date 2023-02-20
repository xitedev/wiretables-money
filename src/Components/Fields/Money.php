<?php

namespace Xite\WiretablesMoney\Components\Fields;

use Illuminate\Contracts\View\View;
use Xite\Wireforms\Components\Fields\Field;

class Money extends Field
{
    public function __construct(
        public string $name,
        public $value = null,
        public bool $required = false,
        public bool $disabled = false,
        public bool $readonly = false,
        public bool $showLabel = true,
        public ?string $label = null,
        public ?string $key = null,
        public ?string $placeholder = null,
        public ?string $help = null,
        public ?string $innerClass = null,
        public bool $lazy = false,
        public ?float $min = null,
        public ?float $max = null,
        public ?float $step = null
    ) {
        parent::__construct(
            $name,
            $value,
            $required,
            $disabled,
            $readonly,
            $showLabel,
            $label,
            $key,
            $placeholder,
            $help,
            $innerClass
        );
    }

    public function render(): View
    {
        return view('wiretables-money::components.fields.money')
            ->with($this->data());
    }
}
