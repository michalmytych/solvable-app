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
                    <x-input-error :messages="$errors->storeProblem->get('title')" class="mt-2"/>
                </div>
                <div>
                    <x-textarea
                            id="content"
                            name="content"
                            class="resize-none mt-1 block w-full placeholder-gray-600 text-xl transition duration-500 dark:hover:bg-gray-800 pl-3"
                            rows="1"
                            placeholder="{{ __('Content') }}"
                    />
                    <x-input-error :messages="$errors->storeProblem->get('content')" class="mt-2"/>
                </div>
                <div class="grid" id="submitButtonWrapper" style="display: none">
                    <x-primary-button class="place-self-end">{{ __('Save') }}</x-primary-button>
                </div>
            </x-form>
        </x-container>
        <x-space height="64"/>
    </x-half-container>

    <x-footer></x-footer>

    @push('scripts')
        <script>
            /** * * * Handle inputs live validation * * * */
                // @todo - move to separate script
            const title = document.getElementById('title');
            const content = document.getElementById('content');
            const submitButtonWrapper = document.getElementById('submitButtonWrapper');

            const updateSubmitButtonVisibility = () => {
                const titleValue = title.value;
                const contentValue = content.value;

                if (!titleValue || !contentValue) {
                    submitButtonWrapper.style.display = 'none';
                }

                console.log(titleValue, contentValue)
                if (titleValue && contentValue) {
                    submitButtonWrapper.style.display = '';
                }
            }

            window.onload = () => {
                updateSubmitButtonVisibility();
                title.addEventListener('input', () => updateSubmitButtonVisibility());
                content.addEventListener('input', () => updateSubmitButtonVisibility());
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
