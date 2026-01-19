@blaze

@php
$classes = Flux::classes()
->add('px-6 py-4')
;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card-body>
    {{ $slot }}
</div>