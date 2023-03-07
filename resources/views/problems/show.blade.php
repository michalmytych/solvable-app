<x-app-layout>

    <x-half-container>
        <x-container>
            <div>
                <x-link href="{{ route('problem.index') }}">{{ __('Problems') }}</x-link>
                <x-secondary>/</x-secondary>
                <x-link href="{{ route('problem.show', ['problem' => $problem->id]) }}">{{ shorten_str($problem->title) }}</x-link>
            </div>

            <x-page-header>
                <x-space height="4"/>
                <x-header h="1">{{ $problem->title }}</x-header>
                <x-space height="4"/>
                <x-datetime date="{{ $problem->created_at }}">{{ __('Created at') }}</x-datetime>
                <x-space height="5"/>
            </x-page-header>

            <x-card header="{{ $problem->title }}" id="{{ $problem->id }}_problem">
                <x-paragraph>
                    {{ $problem->content }}
                </x-paragraph>
            </x-card>

        </x-container>
        <x-space height="64"/>
    </x-half-container>

    <x-footer></x-footer>
</x-app-layout>