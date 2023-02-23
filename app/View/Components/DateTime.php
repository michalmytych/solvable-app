<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class DateTime extends Component
{
    public Carbon $dateTime;

    public ?string $format;

    public function __construct(Carbon|string $date, ?string $format = null)
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        $this->dateTime = $date->setTimezone($this->timezone());
        $this->format   = $format;
    }

    public function render(): View
    {
        return view('components.datetime', [
            'dateTime' => $this->dateTime->format($this->format())
        ]);
    }

    protected function format(): string
    {
        return $this->format ?? 'Y-m-d H:i:s';
    }

    protected function timezone(): mixed
    {
        return optional(auth()->user())->timezone ?? 'Europe/Warsaw';
    }
}