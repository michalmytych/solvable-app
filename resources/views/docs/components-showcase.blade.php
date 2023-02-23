<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Components showcase') }}
        </h2>
    </x-slot>

    <div class="p-12 py-12 w-2/3 mx-auto">
        <div class="lg:px-8">

            <!-- Pagination display component -->
            <x-card header="Pagination">
                <x-pagination></x-pagination>
            </x-card>

            <!-- File drop component -->
            <x-card header="File drop">
                <x-file-drop></x-file-drop>
            </x-card>

            <!-- Steps component -->
            <x-card header="Steps">
                <x-steps></x-steps>
            </x-card>

            <!-- Progress component -->
            <x-card header="Progress">
                <x-progress>
                    Performing tests...
                </x-progress>
            </x-card>

            <!-- Console component -->
            <x-card header="Console">
                <x-console></x-console>
            </x-card>

            <!-- Datetime component -->
            <x-card header="Datetime">
                <x-datetime format="d-m-Y, h:i:s">{{ now()->toString() }}</x-datetime>
            </x-card>

        </div>
    </div>

    </div>
</x-app-layout>