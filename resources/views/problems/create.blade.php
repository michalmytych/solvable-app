<x-app-layout>

    <x-half-container>
        <x-container>
            <div>
                <x-link href="{{ route('problem.index') }}">{{ __('Problems') }}</x-link>
                <x-secondary>/</x-secondary>
                <x-link href="{{ route('problem.create') }}">{{ __('Create new problem') }}</x-link>
            </div>

            <x-form method="POST" action="{{ route('problem.store') }}">
                <div>
                    <x-transparent-input id="title" name="title" placeholder="{{ __('Title') }}"/>
                    <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                </div>
                <div>
                    <x-textarea
                            id="content"
                            name="content"
                            class="resize-none mt-1 block w-full placeholder-gray-600 text-xl transition duration-500 dark:hover:bg-gray-800 pl-3"
                            rows="1"
                            placeholder="{{ __('Content') }}"
                    />
                    <x-input-error :messages="$errors->get('content')" class="mt-2"/>
                </div>
                <div>
                    <x-transparent-input
                            id="chars_limit"
                            name="chars_limit"
                            type="number"
                            class="text-xl"
                            placeholder="{{ __('Code length limit') }}"
                    />
                    <x-input-error :messages="$errors->get('chars_limit')" class="mt-2"/>
                </div>
                <div class="ml-0.5">
                    <x-select
                            name="course_id"
                            :options="$courses"
                            :emptySelectedOption="__('Select course')"
                    />
                    <x-input-error :messages="$errors->get('course_id')" class="mt-2"/>
                    <x-space height="4"/>
                    <x-select
                            name="group_id"
                            :options="$groups"
                            :emptySelectedOption="__('Select group')"
                    />
                    <x-input-error :messages="$errors->get('group_id')" class="mt-2"/>
                </div>
                <div class="ml-3">
                    <x-verbose-checkbox
                            name="code_languages_ids"
                            label="{{ __('Allowed code languages') }}"
                            :boxes="$codeLanguages"
                    />
                    <x-input-error :messages="$errors->get('code_languages_ids')" class="mt-2"/>
                </div>
                <div>
                    @include('problems.partials.tests-input')
                </div>
                <x-spinner id="spinner" style="display: none;" class="ml-2">{{ __('Creating new problem') }}</x-spinner>
                <div class="grid" id="submitButtonWrapper" style="display: none">
                    <x-primary-button id="submitButton" class="place-self-end">{{ __('Save') }}</x-primary-button>
                </div>
            </x-form>
        </x-container>
        <x-space height="64"/>
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
