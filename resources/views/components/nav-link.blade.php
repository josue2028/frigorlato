@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'inline-flex items-center rounded-full bg-white/16 px-4 py-2 text-sm font-semibold text-bone shadow-[0_12px_30px_rgba(255,255,255,0.08)] ring-1 ring-white/10 transition duration-300'
        : 'inline-flex items-center rounded-full px-4 py-2 text-sm font-medium text-brand-100 transition duration-300 hover:-translate-y-0.5 hover:bg-white/10 hover:text-bone';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
