<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Components showcase') }}
        </h2>
    </x-slot>

    <div class="p-12 py-12 w-2/3 mx-auto">
        <div class="lg:px-8">

            <!-- Pagination display component -->
            <x-card header="Pagination" id="pagination_display_component">
                <x-pagination></x-pagination>
            </x-card>

            <!-- File drop component -->
            <x-card header="File drop" id="file_drop_component">
                <x-file-drop></x-file-drop>
            </x-card>

            <!-- Steps component -->
            <x-card header="Steps" id="steps_component">
                <x-steps></x-steps>
            </x-card>

            <!-- Progress component -->
            <x-card header="Progress" id="progress_component">
                <x-progress>
                    Performing tests...
                </x-progress>
            </x-card>

            <!-- Console component -->
            <x-card header="Console" id="console_component">
                <x-console></x-console>
            </x-card>

            <!-- Datetime component -->
            <x-card header="Datetime" id="datetime_component">
                <x-datetime date="{{ now() }}" format="d M y, h:i:s" />
            </x-card>

            <!-- Paragraph skeleton component -->
            <x-card header="Paragraph skeleton" id="paragraph_skeleton_component">
                <x-paragraph-skeleton></x-paragraph-skeleton>
            </x-card>

            <!-- Paragraph component -->
            <x-card header="Paragraph" id="paragraph_component">
                <x-paragraph>
                    I wish it need not have happened in my time," said Frodo. "So do I," said Gandalf, "and so do all who live to see such times. But that is not for them to decide. All we have to decide is what to do with the time that is given us.
                </x-paragraph>
            </x-card>

            <!-- Gradient header component -->
            <x-card header="Gradient header" id="gradient_header_component">
                <x-gradient-header>
                    Solvable UI Kit
                </x-gradient-header>
            </x-card>

            <!-- Headers components -->
            <x-card header="Headers" id="headers_components">
                <x-header></x-header>
                <x-header h="2"></x-header>
                <x-header h="3"></x-header>
                <x-header h="4"></x-header>
                <x-header h="5"></x-header>
            </x-card>

            <!-- Grid gallery component -->
            <x-card header="Grid gallery" id="grid_gallery_component">
                <x-grid-gallery></x-grid-gallery>
            </x-card>

        </div>
    </div>

<x-footer></x-footer>
</x-app-layout>