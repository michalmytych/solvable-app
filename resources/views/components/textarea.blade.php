<textarea
        rows="{{ $rows ?? 20 }}"
        cols="{{ $cols ?? 80 }}"
        {{ isset($disabled) ? 'disabled' : '' }}
        placeholder="{{ $placeholder ?? '' }}"
        {!! $attributes->merge(['class' => 'focus:outline-none p-1.5 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm border-none']) !!}
>{{ $value ?? null }}</textarea>