<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Collection;

class VerboseCheckbox extends Component
{
    public array $boxes;

    public string $name;

    public ?string $label;

    public ?string $boxValueKey;

    public array $checkedValues;

    public function __construct(
        string           $name,
        ?string          $label = null,
        string           $boxLabelKey = 'name',
        string           $boxValueKey = 'id',
        array|Collection $boxes = [],
        array|Collection $checkedValues = [],
    ) {
        $this->name          = $name;
        $this->label         = $label;
        $this->boxValueKey   = $boxValueKey;
        $this->checkedValues = $checkedValues;

        $this->boxes = $boxes instanceof Collection ? $boxes->toArray() : $boxes;

        $this->boxes = array_map(
            function($box) use ($boxValueKey, $checkedValues, $boxLabelKey) {
                $value = data_get($box, $boxValueKey);

                $box['__verbose_checkbox_checked'] = in_array($value, $checkedValues);
                $box['__verbose_checkbox_value']   = $value;
                $box['__verbose_checkbox_label']   = data_get($box, $boxLabelKey);

                return $box;
            },
            $this->boxes
        );
    }

    public function render(): View
    {
        return view('components.verbose-checkbox');
    }
}