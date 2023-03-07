<div>
    <x-space height="8"/>
    <x-header h="4">{{ __('Groups') }}</x-header>
    <x-space height="4"/>
    <div class="grid-cols-3	">
        @foreach($groups as $group)
            <x-link href="{{ route('group.show', ['group' => $group->id]) }}" class="hover:border-indigo-500">
                <x-card id="{{ $group->id }}_group">
                    <div class="flex">
                        <x-gradient-block class="mr-6 mt-2"/>
                        <div>
                            <x-header h="5">{{ $group->name }}</x-header>
                            <x-secondary>{{ $group->code }}</x-secondary>
                        </div>
                    </div>
                </x-card>
            </x-link>
        @endforeach
    </div>
</div>