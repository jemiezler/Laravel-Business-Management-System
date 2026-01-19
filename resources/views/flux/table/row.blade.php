@blaze

@php
$classes = Flux::classes()
->add('hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50 transition-colors')
;
@endphp

<tr {{ $attributes->class($classes) }} data-flux-table-row>
    {{ $slot }}
</tr>