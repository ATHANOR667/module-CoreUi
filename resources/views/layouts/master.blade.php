<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BuildingSaaS') }}</title>

    @vite(['Modules/CoreUI/resources/css/coreui.css'])
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">

<div class="min-h-screen flex">
    <aside class="w-64 bg-white border-r border-slate-200 hidden md:block">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-primary">CoreUI</h2>
        </div>
    </aside>

    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>

</body>
</html>
