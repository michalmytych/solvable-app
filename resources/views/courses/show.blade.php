<x-app-layout>

    <div class="lg:w-1/2 md:w-2/3 sm:w-full mx-auto">
        <x-container>
            <div class="flex items-center justify-between">
                <div>
                    <x-link href="{{ route('course.index') }}">{{ __('Courses') }}</x-link>
                    <x-secondary>/</x-secondary>
                    <x-link href="{{ route('course.show', ['course' => $course->id]) }}">{{ $course->name }}</x-link>
                </div>
                <div>
                    <a href="{{ route('course.edit', ['course' => $course->id]) }}" class="cursor-pointer">
                        <x-icons.edit/>
                    </a>
                </div>
            </div>

            <x-page-header>
                <x-space height="4"/>
                <x-header h="1">{{ $course->name }}</x-header>
                <x-space height="4"/>
                <x-datetime date="{{ $course->created_at }}">{{ __('Created at') }}</x-datetime>
                <x-space height="4"/>
            </x-page-header>

            <x-paragraph>
                {{ $course->description }}
            </x-paragraph>

        </x-container>
        <x-space height="64"/>
    </div>

    <x-footer></x-footer>
</x-app-layout>