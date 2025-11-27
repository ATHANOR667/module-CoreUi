@props(['align' => 'left'])

@php
    $alignment = match($align) {
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left'
    };
@endphp

<th {{ $attributes->merge(['class' => "px-6 py-3 $alignment text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider bg-slate-50 dark:bg-slate-800"]) }}>
    {{ $slot }}
</th>
