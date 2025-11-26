@props([
    'title' => config('app.name'),
    'heading' => null
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

    @livewireStyles
    @livewireScripts

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="h-full bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-slate-100 transition-colors duration-300 ease-in-out flex flex-col min-h-screen font-sans antialiased">

<header class="bg-primary dark:bg-slate-800 text-white p-4 shadow-md transition-colors duration-300 ease-in-out">
    <div class="container mx-auto flex justify-between items-center">

        <div class="flex-grow text-center">
            <h1 class="text-2xl md:text-3xl font-extrabold">
                {{ $heading ?? config('app.name') }}
            </h1>
        </div>

        <div class="flex-shrink-0 ml-4">
            <x-coreui::theme-toggle />
        </div>
    </div>
</header>

<main class="flex-grow container mx-auto p-4 flex flex-col items-center justify-center">
    <div class="w-full max-w-sm md:max-w-md mb-6 space-y-4">

        @if (session('success'))
            <x-coreui::alert type="success">
                {{ session('success') }}
            </x-coreui::alert>
        @endif

        @if (session('error'))
            <x-coreui::alert type="error">
                {{ session('error') }}
            </x-coreui::alert>
        @endif

        @if (session('message'))
            <x-coreui::alert type="info">
                {{ session('message') }}
            </x-coreui::alert>
        @endif

    </div>

    {{ $slot }}

</main>

<footer class="bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 p-4 text-center shadow-inner mt-auto transition-colors duration-300 ease-in-out">
    <div class="container mx-auto">
        <p class="text-sm md:text-base">
            &copy; {{ date('Y') }} {{ config('app.name') }}.
            <span class="hidden sm:inline">Tous droits réservés.</span>
        </p>
    </div>
</footer>

</body>
</html>
