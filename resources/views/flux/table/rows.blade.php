@blaze

@php
$classes = Flux::classes()
->add('divide-y divide-zinc-200 dark:divide-zinc-700')
;
@endphp

<tbody {{ $attributes->class($classes) }} data-flux-table-rows>
    {{ $slot }}
</tbody>