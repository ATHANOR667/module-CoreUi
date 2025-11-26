@props(['active' => false])

@php
    $classes = ($active ?? false)
                ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-primary text-left text-base font-medium text-primary bg-primary/10 transition duration-150 ease-in-out'
                : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-slate-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
