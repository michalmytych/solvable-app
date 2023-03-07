<x-app-layout>

    <x-half-container>
        <x-container>
            <div>
                <x-link href="{{ route('course.index') }}">{{ __('Courses') }}</x-link>
                <x-secondary>/</x-secondary>
                <x-link href="{{ route('course.show', ['course' => $course->id]) }}">{{ shorten_str($course->name) }}</x-link>
                <x-secondary>/</x-secondary>
                <x-link href="{{ route('course.create') }}">{{ __('Edit ') }}</x-link>
            </div>

            <x-form method="POST" action="{{ route('course.store') }}">
                <div>
                    <x-transparent-input
                            id="name"
                            name="name"
                            placeholder="{{ __('Name') }}"
                            value="{{ $course->name }}"
                    />
                    <x-input-error :messages="$errors->storeCourse->get('name')" class="mt-2"/>
                </div>
                <div>
                    <x-textarea
                            id="description"
                            name="description"
                            class="resize-none mt-1 block w-full placeholder-gray-600 text-xl transition duration-500 dark:hover:bg-gray-800 pl-3"
                            rows="1"
                            value="{{ $course->description }}"
                            placeholder="{{ __('Description') }}"
                    />
                    <x-input-error :messages="$errors->storeCourse->get('description')" class="mt-2"/>
                </div>
                <div class="grid" id="submitButtonWrapper" style="display: none">
                    <x-primary-button class="place-self-end">{{ __('Save') }}</x-primary-button>
                </div>
            </x-form>
        </x-container>
        <x-space height="screen"/>
    </x-half-container>

    <x-footer></x-footer>

    @push('scripts')
        <script>
            /** * * * Handle inputs live validation * * * */
                // @todo - move to separate script
            const name = document.getElementById('name');
            const description = document.getElementById('description');
            const submitButtonWrapper = document.getElementById('submitButtonWrapper');

            const updateSubmitButtonVisibility = () => {
                const nameValue = name.value;
                const descriptionValue = description.value;

                if (!nameValue || !descriptionValue) {
                    submitButtonWrapper.style.display = 'none';
                }

                if (nameValue && descriptionValue) {
                    submitButtonWrapper.style.display = '';
                }
            }

            window.onload = () => {
                updateSubmitButtonVisibility();
                name.addEventListener('input', () => updateSubmitButtonVisibility());
                description.addEventListener('input', () => updateSubmitButtonVisibility());
            }
        </script>
        <script>
            /** * * * Live textarea resize * * * */
                // @todo - move to separate script
            const tx = document.getElementsByTagName("textarea");
            for (let i = 0; i < tx.length; i++) {
                tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
                tx[i].addEventListener("input", e => onTextareaInput(e), false);
            }

            function onTextareaInput(e) {
                e.target.style.height = 0;
                e.target.style.height = (e.target.scrollHeight) + "px";
            }
        </script>
    @endpush
</x-app-layout>
