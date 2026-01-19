@blaze

@php
$classes = Flux::classes()
->add('border-b border-zinc-200 dark:border-zinc-700')
;
@endphp

<thead {{ $attributes->class($classes) }} data-flux-table-columns>
    <tr>
        {{ $slot }}
    </tr>
</thead>