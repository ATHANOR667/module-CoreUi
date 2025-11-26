@props([
    'id',
    'maxWidth' => '2xl',
    'title' => null
])

@php
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
        'full' => 'sm:max-w-full',
    ][$maxWidth];
@endphp

<div
    x-data="{ show: @entangle($attributes->wire('model')) }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    x-cloak
    class="relative z-50"
>
    {{-- Overlay --}}
    <div x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity"
         @click="show = false">
    </div>

    {{-- Panel --}}
    <div class="fixed inset-0 z-10 overflow-y-auto">
        {{-- Ajustement ici : p-4 sur mobile, p-6 ou plus sur desktop --}}
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-800 text-left shadow-2xl transition-all sm:my-8 w-full {{ $maxWidth }}"
            >

                {{-- Header : Padding réduit sur mobile --}}
                @if($title)
                    <div class="px-4 py-3 sm:px-6 sm:py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/20">
                        <h3 class="text-base sm:text-lg font-semibold text-slate-900 dark:text-white truncate pr-4">
                            {{ $title }}
                        </h3>
                        <button @click="show = false" class="text-slate-400 hover:text-slate-500 dark:hover:text-slate-300 focus:outline-none">
                            <span class="sr-only">Fermer</span>
                            <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                {{-- Contenu : Padding réduit sur mobile --}}
                <div class="px-4 py-4 sm:px-6 sm:py-6">
                    {{ $slot }}
                </div>

                {{-- Footer : Padding réduit sur mobile --}}
                @if(isset($footer))
                    <div class="px-4 py-3 sm:px-6 sm:py-4 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-700 flex flex-col-reverse sm:flex-row-reverse gap-2 sm:gap-3">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
