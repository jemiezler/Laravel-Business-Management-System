@blaze

@props([
'align' => 'start',
'font' => 'normal',
])

@php
$classes = Flux::classes()
->add('py-3 px-4 text-sm text-zinc-800 dark:text-zinc-200')
->add(match ($align) {
'start' => 'text-left',
'center' => 'text-center',
'end' => 'text-right',
})
->add(match ($font) {
'medium' => 'font-medium',
default => 'font-normal',
})
;
@endphp

<td {{ $attributes->class($classes) }} data-flux-table-cell>
    {{ $slot }}
</td>