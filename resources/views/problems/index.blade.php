<x-app-layout>

    <x-half-container>
        <x-container>
            <x-page-header>
                <x-header h="1">{{ __('Problems') }}</x-header>
                <x-space height="3"/>
                <x-paragraph>
                    {{ __('Programming problems available to you.') }}
                </x-paragraph>
                <x-space height="3"/>
                <x-link href="{{ route('problem.create') }}">
                    <span class="font-bold">+</span>
                    {{ __(('Add new problem')) }}
                </x-link>
            </x-page-header>
            <x-space height="4"/>

            @foreach($problems as $problem)
                <x-card header="{{ $problem->title }}" id="{{ $problem->id }}_problem">
                    <x-paragraph>
                        {{ $problem->content }}
                        <x-space height="3"/>
                        <x-link href="{{ route('problem.show', ['problem' => $problem->id]) }}">
                            {{ __(('See more')) }}
                        </x-link>
                    </x-paragraph>
                </x-card>
            @endforeach
        </x-container>
    </x-half-container>
    <x-space height="64"/>

    <x-footer></x-footer>
</x-app-layout>