<div class="italic text-gray-500">
    @if($slot instanceof Carbon\Carbon)
        {{ $slot->format($format ?? 'd.m.Y h:m:i') }}
    @else
        {{ $slot ? Carbon\Carbon::parse($slot)->format($format ?? 'd.m.Y h:m:i') : __('No data.') }}
    @endif
</div>