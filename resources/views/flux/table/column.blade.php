@blaze

@props([
'align' => 'start',
])

@php
$classes = Flux::classes()
->add('py-3 px-4 text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400')
->add(match ($align) {
'start' => 'text-left',
'center' => 'text-center',
'end' => 'text-right',
})
;
@endphp

<th {{ $attributes->class($classes) }} data-flux-table-column>
    {{ $slot }}
</th>