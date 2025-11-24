@extends('coreui::layouts.master')

@section('content')
    <div class="max-w-7xl mx-auto">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Bienvenue sur BuildingSaaS</h1>
            <p class="mt-2 text-slate-600">Sélectionnez un module pour commencer à travailler.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <x-coreui::action-card
                url="/stock"
                title="Gestion des Stocks"
                description="Entrées, sorties et inventaires."
            >
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </x-slot:icon>
            </x-coreui::action-card>

            <x-coreui::action-card
                url="/admin"
                title="Administration"
                description="Gérer les utilisateurs et les rôles."
            >
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </x-slot:icon>
            </x-coreui::action-card>

            <div class="p-6 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col items-center justify-center text-center">
                <p class="mb-4 text-sm text-slate-500">Action rapide</p>
                <x-coreui::button variant="primary">
                    Créer une vente
                </x-coreui::button>
            </div>

        </div>
    </div>
@endsection
