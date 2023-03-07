<x-app-layout>

    <x-half-container>
        <x-container>
            <div class="flex items-center justify-between">
                <div>
                    <x-link href="{{ route('docs.index') }}">Docs</x-link>
                    <x-secondary>/</x-secondary>
                    <x-link href="{{ route('docs.components_showcase') }}">Components showcase</x-link>
                </div>
            </div>
            <x-space height="3"/>

            <x-page-header>
                <x-gradient-header>
                    Solvable UI Kit
                </x-gradient-header>
                <x-space height="2"/>
                <x-header h="2">Components showcase</x-header>
                <x-space height="4"/>
                <x-paragraph>
                    To use any of components, copy code from
                    <x-code>components-showcase.blade.php</x-code>
                    , and paste it where you need it.
                    Use component attributes to parametrize view rendering.
                </x-paragraph>
                <x-space height="5"/>
            </x-page-header>

            <!-- Container component -->
            <x-card header="Container" id="container_component">
                <x-container>
                    <!-- * * * Example * * * -->
                    <x-code>
                        Content and child components here.
                    </x-code>
                    <!-- * * * Example * * * -->
                </x-container>

            </x-card>

            <!-- Link component -->
            <x-card header="Link" id="link_component">
                <x-link href="#">This is link</x-link>
            </x-card>

            <!-- Secondary text component -->
            <x-card header="Secondary text" id="secondary_text_component">
                <x-secondary>This is secondary text</x-secondary>
            </x-card>

            <!-- Pagination display component -->
            <x-card header="Pagination" id="pagination_display_component">
                <x-pagination/>
            </x-card>

            <!-- File drop component -->
            <x-card header="File drop" id="file_drop_component">
                <x-file-drop/>
            </x-card>

            <!-- Steps component -->
            <x-card header="Steps" id="steps_component">
                <x-steps/>
            </x-card>

            <!-- Progress component -->
            <x-card header="Progress" id="progress_component">
                <x-progress>
                    Performing tests...
                </x-progress>
            </x-card>

            <!-- Console component -->
            <x-card header="Console" id="console_component">
                <x-console/>
            </x-card>

            <!-- Datetime component -->
            <x-card header="Datetime" id="datetime_component">
                <x-datetime date="{{ now() }}" format="d M y, h:i:s"/>
            </x-card>

            <!-- Paragraph skeleton component -->
            <x-card header="Paragraph skeleton" id="paragraph_skeleton_component">
                <x-paragraph-skeleton/>
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
                    Gradient header
                </x-gradient-header>
            </x-card>

            <!-- Headers components -->
            <x-card header="Headers" id="headers_components">
                <x-header>Header 1</x-header>
                <x-header h="2">Header 2</x-header>
                <x-header h="3">Header 3</x-header>
                <x-header h="4">Header 4</x-header>
                <x-header h="5">Header 5</x-header>
            </x-card>

            <!-- Grid gallery component -->
            <x-card header="Grid gallery" id="grid_gallery_component">
                <x-grid-gallery/>
            </x-card>

            <!-- Grid gallery component -->
            <x-card header="Data table" id="data_table_component">
                <x-data-table/>
            </x-card>

            <!-- Spinner component -->
            <x-card header="Spinner" id="spinner_component">
                <x-spinner/>
            </x-card>

            <!-- Search component -->
            <x-card header="Search" id="search_component">
                <x-search placeholder="Search..."/>
            </x-card>

            <!-- Select component -->
            <x-card header="Select" id="select_component">
                <x-select name="test"/>
            </x-card>

            <!-- Verbose checkbox component -->
            <x-card header="Verbose checkbox" id="verbose_checkbox_component">
                <x-verbose-checkbox name="test"/>
            </x-card>

            <!-- Form component -->
            <x-card header="Form" id="form_component">
                <x-form method="GET" action="#">
                    <!-- * * * Example * * * -->
                    <div>
                        <x-input-label for="test_input" :value="__('Test input')"/>
                        <x-text-input
                                id="test_input"
                                name="test_input"
                                placeholder="Placeholder..."
                                class="mt-1 block w-full p-2 focus:outline-none"
                        />
                    </div>
                    <!-- * * * Example * * * -->
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </x-form>
            </x-card>
        </x-container>
    </x-half-container>

    <x-footer></x-footer>
</x-app-layout>
