<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Contracts\DataCollectable;

class Select extends Component
{
    public string $name;

    public ?string $label;

    public mixed $options;

    public string $optionValueKey;

    public ?string $selectedOptionValue;

    public string $optionContentKey;

    public ?string $emptySelectedOption;

    public function __construct(
        string  $name,
        ?string $label = null,
        string  $optionValueKey = 'id',
        string  $optionContentKey = 'name',
        ?string $emptySelectedOption = null,
        mixed   $options = [],
        ?string $selectedOptionValue = null,
    ) {
        $this->name                = $name;
        $this->label               = $label;
        $this->optionValueKey      = $optionValueKey;
        $this->emptySelectedOption = $emptySelectedOption;
        $this->selectedOptionValue = $selectedOptionValue;
        $this->optionContentKey    = $optionContentKey;
        $this->options             = is_array($options) ? $options : $options->toArray();
    }

    public function render(): View
    {
        return view('components.select');
    }
}