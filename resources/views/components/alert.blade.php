@props(['type' => 'info', 'dismissible' => true])

@php
    $colors = match($type) {
        'success' => 'bg-green-100 dark:bg-green-800 border-green-400 dark:border-green-700 text-green-700 dark:text-green-100',
        'error', 'danger' => 'bg-red-100 dark:bg-red-800 border-red-400 dark:border-red-700 text-red-700 dark:text-red-100',
        default => 'bg-blue-100 dark:bg-blue-800 border-blue-400 dark:border-blue-700 text-blue-700 dark:text-blue-100', // Info/Message
    };
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:leave.opacity.duration.500ms
    {{ $attributes->merge(['class' => "{$colors} border px-4 py-3 rounded relative shadow-md flex items-center justify-between mb-4"]) }}
    role="alert"
>
    <span class="block sm:inline">
        {{ $slot }}
    </span>

    @if($dismissible)
        <button @click="show = false" class="ml-4 focus:outline-none opacity-70 hover:opacity-100 transition-opacity">
            <svg class="h-5 w-5" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    @endif
</div>
