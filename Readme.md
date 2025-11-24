# Module CoreUI - Design System & UI Kit

## 🎨 Description
**CoreUI** est la librairie d'interface utilisateur centralisée pour l'écosystème BuildingSaaS.

C'est un module **agnostique** et **transversal** : il ne contient aucune logique métier ni accès à la base de données. Il fournit les briques visuelles (Composants Blade, Layouts, Configuration Tailwind) pour garantir que tous les modules fonctionnels (Stock, Ventes, RH) partagent une identité visuelle unique et cohérente.

## 📦 Stack Technique
* **CSS :** Tailwind CSS 4.0 (Configuration centralisée ici)
* **JS :** Alpine.js 3.x (Pour les intéractions UI : Modales, Dropdowns)
* **Composants :** Blade & Livewire 3 compatible.

## 🛠 Installation

Ce module doit être cloné dans le dossier `Modules` de l'application hôte.

```bash
cd Modules
git clone [https://github.com/ATHANOR667/module-coreui.git](https://github.com/ATHANOR667/module-coreui.git) CoreUI
```

## 💻 Utilisation

### 1. Utiliser un Layout
Dans vos modules fonctionnels, étendez toujours les layouts de CoreUI :

```blade
@extends('coreui::layouts.master')

@section('content')
    <h1>Mon Contenu</h1>
@endsection
```

### 2. Utiliser les Composants
Utilisez les composants avec le préfixe `coreui::`.

```blade
<x-coreui::card title="Ajouter un produit">
    
    <form wire:submit="save">
        <x-coreui::input label="Nom du produit" wire:model="name" />

        <x-coreui::button type="submit" variant="primary">
            Sauvegarder
        </x-coreui::button>
    </form>

</x-coreui::card>
```

## 📂 Structure du Module
* `Resources/views/components` : Tous les atomes UI (Buttons, Inputs, Alerts).
* `Resources/views/layouts` : Les gabarits de page (Master, Auth, Blank).
* `Resources/assets` : Les fichiers CSS/JS sources (point d'entrée de Tailwind).

## ⚠️ Règles de Contribution
1. **Zéro Logique Métier :** Un composant ne doit jamais faire de requête SQL.
2. **Mobile First :** Tous les composants doivent être responsives par défaut.
3. **Props Typées :** Utilisez les classes de composants Blade pour définir clairement les props acceptées.
