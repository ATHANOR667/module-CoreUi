@props(['value' => 0, 'max' => 100, 'color' => 'primary'])

@php
    $percentage =  $value == 0 ? 0 : ($value / $max) * 100;
    $colors = [
        'primary' => 'bg-primary',
        'success' => 'bg-emerald-500',
        'danger' => 'bg-red-500',
        'warning' => 'bg-amber-500',
    ];
    $bgColor = $colors[$color] ?? $colors['primary'];
@endphp

<div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
    <div class="h-2.5 rounded-full {{ $bgColor }} transition-all duration-500 ease-out"
         style="width: {{ $percentage }}%"></div>
</div>
