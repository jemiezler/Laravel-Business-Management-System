@blaze

@props([
'padded' => true,
])

@php
$classes = Flux::classes()
->add('bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-xl dark:text-[#EDEDEC] overflow-hidden')
->add($padded ? 'p-6' : '')
;
@endphp

<div {{ $attributes->class($classes) }} data-flux-card>
    {{ $slot }}
</div>