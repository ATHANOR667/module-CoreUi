@props(['active' => false])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-primary text-sm font-medium text-slate-900 dark:text-white transition-colors duration-150 ease-in-out'
                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary-light hover:border-primary/30 transition-colors duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
