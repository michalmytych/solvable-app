<x-app-layout>

    <div class="lg:w-1/2 md:w-2/3 sm:w-full mx-auto">
        <x-container>
            <div>
                <x-link href="{{ route('problem.index') }}">{{ __('Problems') }}</x-link>
                <x-secondary>/</x-secondary>
                <x-link href="{{ route('problem.show', ['problem' => $problem->id]) }}">{{ $problem->title }}</x-link>
            </div>

            <x-page-header>
                <x-header h="1">{{ $problem->title }}</x-header>
                <x-space height="4"/>
                <x-datetime date="{{ $problem->created_at }}">{{ __('Created at') }}</x-datetime>
                <x-space height="4"/>
                <x-paragraph>
                    {{ __('Programming problems available to you.') }}
                </x-paragraph>
            </x-page-header>

            <x-card header="{{ $problem->title }}" id="{{ $problem->id }}_problem">
                <x-paragraph>
                    {{ $problem->content }}
                </x-paragraph>
            </x-card>

        </x-container>
    </div>

    <x-footer></x-footer>
</x-app-layout>