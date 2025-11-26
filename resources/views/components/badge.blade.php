@props([
    'variant' => 'neutral',
    'size' => 'md',
])

@php
    $variants = [
        'primary' => 'bg-primary/10 text-primary border-primary/20',
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20',
        'danger'  => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
        'purple'  => 'bg-purple-50 text-purple-700 border-purple-200 dark:bg-purple-500/10 dark:text-purple-400 dark:border-purple-500/20',
        'neutral' => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600',
    ];

    $sizes = [
        'sm' => 'px-2 py-0.5 text-[10px]',
        'md' => 'px-2.5 py-0.5 text-xs',
    ];

    $classes = 'inline-flex items-center font-medium rounded-full border ' . ($variants[$variant] ?? $variants['neutral']) . ' ' . $sizes[$size];
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
