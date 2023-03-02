<input
        id="{{ $id ?? "input_" . Illuminate\Support\Str::uuid() }}"
        name="{{ $name }}"
        type="{{ $type ?? 'text' }}"
        value="{{ $value ?? '' }}"
        {!! $attributes->merge(['class' => 'outline-none mt-1 block w-full placeholder-gray-600 text-3xl transition duration-500 dark:hover:bg-gray-800 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm border-none']) !!}
        placeholder="{{ $placeholder ?? '' }}"
/>