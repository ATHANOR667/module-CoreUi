@props([
    'title' => config('app.name'),
    'brand' => config('app.name'),
    'homeUrl' => '#'
])

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'system';
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark' || (savedTheme === 'system' && systemDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    {{ $head ?? '' }}

    @livewireStyles
    @livewireScripts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarOpen: false }" class="h-full bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-slate-100 font-sans antialiased flex flex-col min-h-screen">

{{-- Spinner Global --}}
<div wire:loading.delay.longest class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity" x-cloak>
    <div class="flex flex-col items-center p-4 bg-white dark:bg-slate-800 rounded-lg shadow-xl">
        <svg class="animate-spin h-10 w-10 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="mt-3 text-sm font-medium text-slate-700 dark:text-slate-300">Chargement...</span>
    </div>
</div>

<nav class="bg-white dark:bg-slate-800 shadow-sm border-b border-slate-200 dark:border-slate-700 transition-colors duration-300">
    <div class="container mx-auto px-4">
        <div class="flex justify-between h-16">

            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ $homeUrl }}" class="text-xl font-bold text-primary hover:text-primary-hover transition-colors">
                        {{ $brand }}
                    </a>
                </div>

                <div class="hidden md:ml-6 md:flex md:space-x-8">
                    {{ $desktop_menu ?? '' }}
                </div>
            </div>

            <div class="hidden md:flex md:items-center md:space-x-4">
                <x-coreui::theme-toggle />
                {{ $actions ?? '' }}
            </div>

            <div class="-mr-2 flex items-center md:hidden gap-2">
                <x-coreui::theme-toggle />

                <button @click="sidebarOpen = !sidebarOpen"
                        type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary"
                        aria-controls="mobile-menu"
                        :aria-expanded="sidebarOpen">

                    <span class="sr-only">Ouvrir le menu</span>

                    <svg x-show="!sidebarOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <svg x-show="sidebarOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="sidebarOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700"
         id="mobile-menu"
         style="display: none;">

        <div class="pt-2 pb-3 space-y-1 px-2">
            {{ $menu ?? '' }}
        </div>

        <div class="pt-4 pb-4 border-t border-slate-200 dark:border-slate-700 px-4">
            {{ $mobile_actions ?? '' }}
        </div>
    </div>
</nav>

<main class="flex-grow container mx-auto px-4 py-8">

    @if (session('success'))
        <x-coreui::alert type="success" class="mb-6">{{ session('success') }}</x-coreui::alert>
    @endif
    @if (session('error'))
        <x-coreui::alert type="error" class="mb-6">{{ session('error') }}</x-coreui::alert>
    @endif

    {{ $notifications ?? '' }}

    {{ $slot }}
</main>

<footer class="bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 py-6 border-t border-slate-200 dark:border-slate-700 transition-colors duration-300">
    <div class="container mx-auto px-4 text-center">
        <p class="text-sm">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </p>
    </div>
</footer>

</body>
</html>
