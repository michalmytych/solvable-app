<x-link href="{{ route('course.show', ['course' => $course->id]) }}" class="hover:border-indigo-500">
    <x-card id="{{ $course->id }}_course">
        <div class="flex">
            <x-gradient-block class="mr-6"/>
            <x-header h="5">{{ $course->name }}</x-header>
        </div>
    </x-card>
</x-link>
