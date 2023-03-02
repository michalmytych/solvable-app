<a
        href="{{ $href }}"
        class="font-semibold text-indigo-500 hover:text-indigo-400"
        {!! $attributes->merge(['class' => 'font-semibold text-indigo-500 hover:text-indigo-400']) !!}>
    {{ $slot }}
</a>
