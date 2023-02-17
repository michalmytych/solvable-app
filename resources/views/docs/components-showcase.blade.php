<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Components showcase') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Pagination display component -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="pl-6 pt-6 pb-3 font-semibold text-lg text-gray-900 dark:text-gray-100">
                    {{ __('Pagination display') }}
                </div>
                <x-horizontal-separator></x-horizontal-separator>
                <div class="ml-6 mb-6 w-3/4">
                    <x-pagination></x-pagination>
                </div>
            </div>

            <!-- File drop component -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="pl-6 pt-6 pb-3 font-semibold text-lg text-gray-900 dark:text-gray-100">
                    {{ __("File drop") }}
                </div>
                <x-horizontal-separator></x-horizontal-separator>
                <div class="ml-6 mb-6">
                    <x-file-drop></x-file-drop>
                </div>
            </div>

            <!-- Steps component -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="pl-6 pt-6 pb-3 font-semibold text-lg text-gray-900 dark:text-gray-100">
                    {{ __("Steps") }}
                </div>
                <x-horizontal-separator></x-horizontal-separator>
                <div class="ml-6 mb-6">
                    <x-steps></x-steps>
                </div>
            </div>

            <!-- Progress component -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="pl-6 pt-6 pb-3 font-semibold text-lg text-gray-900 dark:text-gray-100">
                    {{ __("Progress") }}
                </div>
                <x-horizontal-separator></x-horizontal-separator>
                <div class="ml-6 mb-6 w-3/4">
                    <x-progress>
                        {{ __("Performing tests...") }}
                    </x-progress>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>