@php
    $htmlMethod = 'get';

    if (!isset($method)) {
        $method = $htmlMethod;
    } else {
        $method = strtolower($method);
    }

    if ($method !== 'get') {
        $htmlMethod = 'post';
    }
@endphp

<form method="{{ $htmlMethod }}" action="{{ $action ?? '#' }}" class="mt-6 space-y-6">
    @csrf
    @method($method)
    {{ $slot }}
</form>