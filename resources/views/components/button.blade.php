@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-bold rounded-xl shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-offset-2 transition-all duration-300 ease-in-out transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary'   => 'bg-primary hover:bg-primary-hover text-white focus:ring-primary dark:focus:ring-offset-slate-900',
        'secondary' => 'bg-white text-slate-700 border border-slate-300 hover:bg-slate-50',
        'danger'    => 'bg-danger hover:bg-red-600 text-white focus:ring-danger',
        'ghost'     => 'bg-transparent text-primary hover:bg-slate-100 shadow-none hover:shadow-none',
    ];

    $sizes = [
        'sm' => 'py-2 px-4 text-sm',
        'md' => 'py-3 px-6 text-base',
        'lg' => 'py-4 px-8 text-lg',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
