@blaze

@php
$classes = Flux::classes()
->add('px-6 py-4 bg-zinc-50/50 dark:bg-white/5 border-t border-zinc-200/50 dark:border-[#fffaed2d]')
;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card-footer>
    {{ $slot }}
</div>