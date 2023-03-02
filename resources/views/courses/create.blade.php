<x-app-layout>

    <div class="lg:w-1/2 md:w-2/3 sm:w-full mx-auto">
        <x-container>
            <div>
                <x-link href="{{ route('course.index') }}">{{ __('Courses') }}</x-link>
                <x-secondary>/</x-secondary>
                <x-link href="{{ route('course.create') }}">{{ __('Create new course') }}</x-link>
            </div>

            <x-form method="POST" action="{{ route('course.store') }}">
                <div>
                    <x-transparent-input id="name" name="name" placeholder="{{ __('Name') }}" />
                    <x-input-error :messages="$errors->storeCourse->get('name')" class="mt-2"/>
                </div>
                <div>
                    <x-textarea
                            id="description"
                            name="description"
                            class="resize-none mt-1 block w-full placeholder-gray-600 text-xl transition duration-500 dark:hover:bg-gray-800 pl-3"
                            rows="1"
                            placeholder="{{ __('Description') }}"
                    />
                    <x-input-error :messages="$errors->storeCourse->get('description')" class="mt-2"/>
                </div>
                <x-spinner id="spinner" style="display: none;" class="ml-2">{{ __('Creating new course') }}</x-spinner>
                <div class="grid" id="submitButtonWrapper" style="display: none">
                    <x-primary-button id="submitButton" class="place-self-end">{{ __('Save') }}</x-primary-button>
                </div>
            </x-form>
        </x-container>
        <x-space height="64"/>
    </div>

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

            /** * * * Handle submit button click * * * */
            const submitButton = document.getElementById('submitButton');
            const spinner = document.getElementById('spinner');

            const handleButtonClick = () => {
                submitButtonWrapper.style.display = 'none';
                spinner.style.display = '';
            }

            window.onload = () => {
                updateSubmitButtonVisibility();
                name.addEventListener('input', () => updateSubmitButtonVisibility());
                description.addEventListener('input', () => updateSubmitButtonVisibility());
                submitButton.addEventListener('click', () => handleButtonClick());
            }
        </script>
    @endpush
</x-app-layout>
