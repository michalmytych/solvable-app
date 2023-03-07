@php

foreach ($options ?? [] as $ix => $option) {
    $options[$ix]['__select_value_key'] = data_get($option, $optionValueKey ?? 'id');
}

@endphp

@if($label)
    <label for="countries" class="text:gray-900 transition duration-500 dark:hover:bg-gray-800 dark:bg-gray-900 dark:text-gray-300">
        {{ $label }}
    </label>
@endif
<select
        id="{{ $name . 'SelectInput' }}"
        name="{{ $name }}"
        class="bg-transparent border-none text-gray-400 rounded-lg block w-full p-2.5 dark:placeholder-gray-400 dark:hover:bg-gray-800"
>
    @if(count($options) === 0)
        <option selected>{{ __('No options') }}</option>
    @endif

    @foreach($options as $option)
        @if(!isset($selectedOptionValue))
            <option selected>{{ $emptySelectedOption ?? __('Select option') }}</option>
        @endif

        <option
                @if(isset($selectedOptionValue))
                    @if($option['__select_value_key'] === $selectedOptionValue)
                        selected
                    @endif
                @endif
                value="{{ $option['__select_value_key'] }}">
            {{ $option[$optionContentKey] }}
        </option>

    @endforeach
</select>
