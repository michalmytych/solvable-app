<x-app-layout>

    <x-half-container>
        <x-container>
            <x-page-header>
                <x-header h="1">{{ __('Courses') }}</x-header>
                <x-space height="3"/>
                <x-paragraph>
                    {{ __('Programming courses available to you.') }}
                </x-paragraph>
                <x-space height="3"/>
                <x-link href="{{ route('course.create') }}">
                    <span class="font-bold">+</span>
                    {{ __(('Add new course')) }}
                </x-link>
            </x-page-header>
            <x-space height="4"/>

            @foreach($courses as $course)
                @include('courses.partials.course-card', ['course' => $course ])
            @endforeach

        </x-container>
    </x-half-container>
    <x-space height="64"/>

    <x-footer></x-footer>
</x-app-layout>