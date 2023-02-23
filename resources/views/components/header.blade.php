@if(isset($h))
    @switch($h)
        @case('1')
        <h1 class="text-5xl font-bold dark:text-white">Header 1</h1>
        @break
        @case('2')
        <h2 class="text-4xl font-bold dark:text-white">Header 2</h2>
        @break
        @case('3')
        <h3 class="text-3xl font-bold dark:text-white">Header 3</h3>
        @break
        @case('4')
        <h4 class="text-2xl font-bold dark:text-white">Header 4</h4>
        @break
        @case('5')
        <h5 class="text-xl font-bold dark:text-white">Header 5</h5>
        @break
    @endswitch
@else
    <h1 class="text-5xl font-bold dark:text-white">Header 1</h1>
@endif