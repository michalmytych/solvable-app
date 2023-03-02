@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
