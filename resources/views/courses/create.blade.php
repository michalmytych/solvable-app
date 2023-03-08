<x-app-layout>

    <x-half-container>
        <x-container>
            <div>
                <x-link href="{{ route('course.index') }}">{{ __('Courses') }}</x-link>
                <x-secondary>/</x-secondary>
                <x-link href="{{ route('course.create') }}">{{ __('Create new course') }}</x-link>
            </div>

            <x-form method="POST" action="{{ route('course.store') }}">
                <div>
                    <x-transparent-input id="name" name="name" placeholder="{{ __('Name') }}" :value="old('name')"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>
                <div>
                    <x-textarea
                            id="description"
                            name="description"
                            class="resize-none mt-1 block w-full placeholder-gray-600 text-xl transition duration-500 dark:hover:bg-gray-800 pl-3"
                            rows="1"
                            :value="old('description')"
                            placeholder="{{ __('Description') }}"
                    />
                    <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                </div>
                <x-spinner id="spinner" style="display: none;" class="ml-2">{{ __('Creating new course') }}</x-spinner>
                <div class="grid" id="submitButtonWrapper" style="display: none">
                    <x-primary-button id="submitButton" class="place-self-end">{{ __('Save') }}</x-primary-button>
                </div>
            </x-form>
        </x-container>
        <x-space height="screen"/>
    </x-half-container>

    <x-footer></x-footer>

    @push('scripts')
        @include('js.validation')
        @include('js.textarea-live-resize')
        @include('js.submit-spinner')
        <script>
            const submitButtonWrapper = document.getElementById('submitButtonWrapper');

            validateRequiredInputsLive(
                ['title', 'content', 'chars_limit'],
                () => {
                    submitButtonWrapper.style.display = 'none'
                },
                () => {
                    submitButtonWrapper.style.display = '';
                },
            );
        </script>
    @endpush
</x-app-layout>
