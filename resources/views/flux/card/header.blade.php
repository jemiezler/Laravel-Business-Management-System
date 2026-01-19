@blaze

@php
$classes = Flux::classes()
->add('px-6 py-4 border-b border-zinc-200/50 dark:border-[#fffaed2d]')
;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card-header>
    {{ $slot }}
</div>