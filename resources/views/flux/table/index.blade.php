@blaze

@props([
'paginate' => null,
])

@php
$classes = Flux::classes()
->add('w-full text-left border-collapse')
;
@endphp

<div class="overflow-x-auto">
    <table {{ $attributes->class($classes) }} data-flux-table>
        {{ $slot }}
    </table>

    @if ($paginate)
    <div class="mt-4">
        {{ $paginate->links() }}
    </div>
    @endif
</div>