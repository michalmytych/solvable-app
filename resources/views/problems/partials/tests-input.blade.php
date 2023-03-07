<!--

1. "input" (text)
2. "time_limit" (int) (milliseconds)
3. "memory_limit" (int) (bytes/megabytes)
4. valid_outputs (array<string>) ()

-->

<div>
    <div id="testInputsContainer">
        <!-- Single input form -->
        <div
                class="ml-2 mt-4"
                id="singleFormInput_0"
                style="display: none;"
        >
            <x-header h="5" class="__header">
                {{ __('Test ') }}1
            </x-header>
            <x-transparent-input
                    id="input"
                    name="input"
                    type="text"
                    class="text-lg mt-2"
                    placeholder="{{ __('Test input') }}"
            />
            <x-transparent-input
                    id="chars_limit"
                    name="chars_limit"
                    type="number"
                    class="text-lg"
                    placeholder="{{ __('Execution time limit') }}"
            />
            <x-transparent-input
                    id="chars_limit"
                    name="chars_limit"
                    type="number"
                    class="text-lg"
                    placeholder="{{ __('Memory usage limit') }}"
            />
        </div>
    </div>

    <div class="flex ml-2 mb-4 mt-4 items-center cursor-pointer" id="newTestInputBtn">
        <x-icons.round-add/>
        <div class="text-white text-xl ml-2">
            {{ __('Add test for problem') }}
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const singleFormInput = document.getElementById('singleFormInput_0');
        const newTestInputBtn = document.getElementById('newTestInputBtn');
        const testInputsContainer = document.getElementById('testInputsContainer');

        const addTestInput = () => {
            if (singleFormInput.style.display === 'none') {
                singleFormInput.style.display = '';
            } else {
                const _clone = singleFormInput.cloneNode(true);
                const testIndex = testInputsContainer.children.length - 1;

                _clone.id = `singleFormInput_${testIndex + 1}`;

                const headerElement = _clone.querySelector('h5');
                let innerTextCopy = headerElement.innerText;

                headerElement.innerText = innerTextCopy.split(' ')[0] + ` ${testIndex + 2}`;
                testInputsContainer.appendChild(_clone);
            }
        }

        newTestInputBtn.addEventListener('click', addTestInput);
    </script>
@endpush