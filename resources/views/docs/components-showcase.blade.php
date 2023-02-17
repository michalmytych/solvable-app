<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Components showcase') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 font-semibold text-lg text-gray-900 dark:text-gray-100">
                    {{ __("Text input") }}
                </div>
                <div class="ml-6 mb-6">
                    <x-text-input></x-text-input>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 font-semibold text-lg text-gray-900 dark:text-gray-100">
                    {{ __("File drop") }}
                </div>
                <div class="ml-6 mb-6">
                    <x-file-drop></x-file-drop>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>