<!--

1. "input" (text)
2. "time_limit" (int) (milliseconds)
3. "memory_limit" (int) (bytes/megabytes)
4. valid_outputs (array<string>) ()

-->

<div>
    <div id="testInputsForm">
        <input type="hidden" id="dataHolder" name="tests_json_data">
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
                    id="time_limit"
                    name="time_limit"
                    type="number"
                    class="text-lg"
                    placeholder="{{ __('Execution time limit') }}"
            />
            <x-transparent-input
                    id="memory_limit"
                    name="memory_limit"
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
        const testInputsForm = document.getElementById('testInputsForm');
        const dataHolder = document.getElementById('dataHolder');

        const addTestInput = () => {
            if (singleFormInput.style.display === 'none') {
                singleFormInput.style.display = '';
            } else {
                const _clone = singleFormInput.cloneNode(true);
                const testIndex = testInputsForm.children.length - 1;

                _clone.id = `singleFormInput_${testIndex + 1}`;

                const headerElement = _clone.querySelector('h5');
                let innerTextCopy = headerElement.innerText;

                headerElement.innerText = innerTextCopy.split(' ')[0] + ` ${testIndex + 2}`;
                testInputsForm.appendChild(_clone);
            }
        }

        const serializeAndSaveData = (data) => {
            dataHolder.value = JSON.stringify(data);
        }

        const getFormData = () => {
            const testsData = [];
            const singleTestInputs = testInputsForm.querySelectorAll(`[id^='singleFormInput_']`);

            singleTestInputs.forEach(function (_input) {
                const testData = {
                    input: _input.querySelector('#input').value,
                    time_limit: _input.querySelector('#time_limit').value,
                    memory_limit: _input.querySelector('#memory_limit').value,
                };

                testsData.push(testData);
            });

            return testsData;
        }

        const updateDataHolder = () => {
            const data = getFormData();
            console.log(data)
            serializeAndSaveData(data);
        }

        const updateHandlers = () => {
            const singleTestInputs = testInputsForm.querySelectorAll(`[id^='singleFormInput_']`);
            console.log(singleTestInputs.length)

            singleTestInputs.forEach(function (_input) {
                console.log('awdaw')
                _input.querySelector('#input')
                    .removeEventListener('input', updateDataHolder)
                _input.querySelector('#input')
                    .addEventListener('input', updateDataHolder);
                _input.querySelector('#time_limit')
                    .removeEventListener('input', updateDataHolder)
                _input.querySelector('#time_limit')
                    .addEventListener('input', updateDataHolder);
                _input.querySelector('#memory_limit')
                    .removeEventListener('input', updateDataHolder)
                _input.querySelector('#memory_limit')
                    .addEventListener('input', updateDataHolder);
            });
        }

        newTestInputBtn.addEventListener('click', () => {
            addTestInput();
            updateHandlers();
        });
    </script>
@endpush