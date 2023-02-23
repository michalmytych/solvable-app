<div class="bg-white dark:bg-black overflow-hidden shadow-sm sm:rounded-lg mb-6 min-h-20 max-h-fit p-1 w-full border-2 border-gray-700">
    <div id="consoleOutput" class="overflow-scroll consoleText" style="height: 100px; scroll-behavior: smooth; display: flex; flex-direction: column;">
        <div style="height: 120px;"></div>
    </div>
    <div class="flex">
        <span class="font-mono text-green-500">$ </span>
        <input id="consoleInput" type="text" class="w-full h-6 bg-black border-none active:outline-none focus:outline-none focus: focus:border-none consoleText"/>
    </div>
</div>

<template id="whiteConsoleRow">
    <div></div>
</template>

<template id="redConsoleRow">
    <div></div>
</template>

<template id="greenConsoleRow">
    <div></div>
</template>

<template id="blueConsoleRow">
    <div></div>
</template>

@push('styles')
    <style>
        .consoleText {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;
            color: white;
            size: 1rem;
        }

        #consoleOutput > * {
            align-self: flex-end;
            background-color: #2563eb;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const _consoleOutput = document.getElementById('consoleOutput');
        const _consoleInput = document.getElementById('consoleInput');

        if ('content' in document.createElement('template')) {
            const whiteConsoleRowTemplate = document.querySelector('#whiteConsoleRow');
            const redConsoleRowTemplate = document.querySelector('#redConsoleRow');
            const greenConsoleRowTemplate = document.querySelector('#greenConsoleRow');
            const blueConsoleRowTemplate = document.querySelector('#blueConsoleRow');

            function displayInConsole(text, color = 'white') {
                let template;

                if (color === 'white') template = whiteConsoleRowTemplate;
                if (color === 'red') template = redConsoleRowTemplate;
                if (color === 'green') template = greenConsoleRowTemplate;
                if (color === 'blue') template = blueConsoleRowTemplate;

                const clone = template.content.cloneNode(true);
                clone.firstChild.textContent = text;

                _consoleOutput.appendChild(clone);
                _consoleOutput.scrollTop += 20

                return clone;
            }
        } else {
            console.log('Browser does not support template HTML tag.');
        }

        window.onload = function () {
            _consoleOutput.style.lineHeight = '20px';

            _consoleInput.addEventListener('change', function () {
                const _input = _consoleInput.value;
                if (_input === '') {
                    return;
                }
                _consoleInput.value = '';
                // Simple echo console
                displayInConsole(`$ ${_input}`);

                // Interpret command
                if (_input === 'clear') {
                    let placeholder = document.createElement('div');
                    placeholder.style.height = '100px';

                    _consoleOutput.innerHTML = '';
                    _consoleOutput.appendChild(placeholder);
                }
            });
        }
    </script>
@endpush