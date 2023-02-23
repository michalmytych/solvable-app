<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6 w-full">
    <div class="pl-6 pt-6 pb-3 font-semibold text-xl text-gray-900 dark:text-gray-100">
        <span class="text-gray-500 font-light" {{ $id ? 'id="' . $id . '"' : ''}}">#</span>
        {{ $header }}
    </div>
    <x-horizontal-separator></x-horizontal-separator>
    <div class="mx-6 my-6 w-5/6">
        {{ $slot }}
    </div>
</div>