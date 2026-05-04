@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'block w-full rounded-xl bg-white/10 px-4 py-3 text-left text-sm font-semibold text-bone ring-1 ring-white/10 transition duration-300'
        : 'block w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-brand-100 transition duration-300 hover:bg-white/10 hover:text-bone';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
